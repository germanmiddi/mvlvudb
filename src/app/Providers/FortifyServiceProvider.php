<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

use App\Models\User;
use App\Models\Manager\Role;

use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });


        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            
            if ($request->email == 'g@gmail.com' && Hash::check($request->password, $user->password)) {
                // Agrega los nuevos valores al array
                $grupoNames = [
                    'APP-VUDS-ALL-VU',
                ];
                // Asigna el array actualizado a la variable de sesión
                session(['userGroups' => $grupoNames]);

                return $user;

            }elseif ($user) {

                // Personaliza la lógica de autenticación aquí
                $url_ldap = 'http://10.100.18.136:8096/gruposUser';
                // $url_ldap = env('URL_LDAP') . '/grupo';
                
                try{
                    
                    $response = Http::post($url_ldap, [
                        'usuario' => $user->email,
                        'clave'   => $request->password,
                    ]);
                    
                    $token = $response->body();
                    // $token = "eyJhbGciOiJIUzI1NiJ9.WyJBUFAtVlVEUy1BTEwtQURNIiwiQVBQLVZVRFMtQUxMLURJUiIsIkZXX1ZQTl9PTk1FRElBIiwiR0RfQ05ZX01WTCIsImFwcF9yZWRiaWJsaW90ZWNhc19hZG1pbiJd.5WZnD6AiXJ0HKMjbpU8FwihgtzaC_ILn48PuoL32yro";
                    $tokenParts   = explode(".", $token);  
                    $tokenHeader  = base64_decode($tokenParts[0]);
                    $tokenPayload = base64_decode($tokenParts[1]);
                    
                    $jwtHeader  = json_decode($tokenHeader);
                    $jwtPayload = json_decode($tokenPayload, true);
                    
                    if($jwtPayload != null){
                        // Convertir descripciones en IDs de roles
                        $grupoIds = Role::whereIn('name', $jwtPayload)->pluck('id')->toArray();
                        $grupoNames = Role::whereIn('name', $jwtPayload)->pluck('name')->toArray();

                        // Guardar los IDs en la tabla pivot
                        $user->roles()->sync($grupoIds);

                        // Asigna el array actualizado a la variable de sesión
                        session(['userGroups' => $grupoNames]);

                        Log::info('Usuario autenticado: ' . $user->email . ' Permisos: ' . print_r($grupoNames, true));
                        return $user;
                    }

                }   catch (\Exception $e) {
                    Log::error('Error al autenticar usuario: ' . $user->email . ' ' . $e->getMessage());
                    return null;
                }


                // // Obtén el valor actual de la variable de sesión si existe
                // $sharedValues = session('shared_values', []);

                // // Agrega los nuevos valores al array
                // $newValues = [
                //     'APP-VUDS-ALL-OP',
                //     'APP-VUDS-NIN-OP',
                //     'APP-VUDS-CBJ-OP',
                //     'APP-VUDS-CBI-OP'
                // ];

                // // Fusiona los nuevos valores con los existentes
                // $sharedValues = array_merge($sharedValues, $newValues);



                // return $user;
            }else{
                return null;
            }
        });
    }
}