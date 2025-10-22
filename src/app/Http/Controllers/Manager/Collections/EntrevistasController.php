<?php

namespace App\Http\Controllers\Manager\Collections;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

//Models
use App\Models\Manager\Person;
use App\Models\Manager\Pais;
use App\Models\Manager\Barrio;
use App\Models\Manager\Localidad;
use App\Models\Manager\CanalAtencion;
use App\Models\Manager\CoberturaMedica;
use App\Models\Manager\EstadoEducativo;
use App\Models\Manager\NivelEducativo;
use App\Models\Manager\TipoDocumento;
use App\Models\Manager\TipoOcupacion;
use App\Models\Manager\TipoPension;
use App\Models\Manager\TipoVivienda;
use App\Models\Manager\SituacionConyugal;
use App\Models\Manager\RolTramite;
use App\Models\Manager\TipoTramite;
use App\Models\Manager\ProgramaSocial;
use App\Models\Manager\Dependencia;
use App\Models\Manager\Tramite;

use App\Models\Manager\AditionalData;
use App\Models\Manager\AddressData;
use App\Models\Manager\ContactData;
use App\Models\Manager\SocialData;
use App\Models\Manager\CajasEntrevista;
use App\Models\Manager\CajasEntrevistasStatus;
use App\Models\Manager\PuntoEntrega;
use App\Models\User;
use App\Models\Manager\EducationData;
use App\Models\Manager\TipoTenencia;
use App\Models\Manager\Cud;
use App\Models\Manager\CajasMotivoSuspension;
use App\Models\Padron;
class EntrevistasController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Collections/Entrevistas/List', [
            'estados' => CajasEntrevistasStatus::all(),
            'sedes' => PuntoEntrega::all(),
            'entrevistadores' => User::whereHas('puntosEntrega')->get(),
            'padrones' => Padron::orderBy('fecha_inicio', 'desc')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'Manager/Collections/Entrevistas/Create',
            [
                'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::where('id', '<>', 10)->get(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 5)->active()->get(),
                'programasSocial' => ProgramaSocial::activo()->get(),
                'puntosEntrega' => PuntoEntrega::all(),
                'entrevistadores' => User::whereHas('puntosEntrega')->get(),
                'tipoTenencia' => TipoTenencia::all(),
                'padrones' => Padron::activos()->orderBy('fecha_inicio', 'desc')->get()
            ]
        );
    }


    public function store(Request $request)
    {
        // Limpiar el documento: eliminar puntos, guiones y espacios
        $documentoLimpio = str_replace(['.', '-', ' '], '', $request['num_documento']);

        // Validar que no exista una entrevista para el mismo padrón y persona
        $existingInterview = CajasEntrevista::where('person_id', $request->person_id)
            ->where('padron_id', $request->padron_id)
            ->first();

        if ($existingInterview) {
            return response()->json([
                'message' => 'Ya existe una entrevista registrada para esta persona en el padrón seleccionado'
            ], 422);
        }

        DB::beginTransaction();
        try {

            // * DNI
            // * Nombre y Apellido
            // * Fecha de Nacimiento
            $person = Person::updateOrCreate(
                [
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $documentoLimpio
                ],
                [
                    'lastname' => $request['lastname'],
                    'name' => $request['name'],
                    'fecha_nac' => $request['fecha_nac'],
                    'tipo_documento_id' => $request['tipo_documento_id'],
                    'num_documento' => $documentoLimpio
                ]
            );

            $aditionalData = AditionalData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'cant_hijos' => $request['cant_hijos'],
                    'situacion_conyugal_id' => $request['situacion_conyugal_id'],
                    'nacionalidad' => $request['pais_id'],
                ]
            );

            AddressData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'calle' => $request['calle'],
                    'number' => $request['number'],
                    'piso' => $request['piso'],
                    'dpto' => $request['dpto'],
                    'latitude' => $request['latitude'],
                    'longitude' => $request['longitude'],
                    'google_address' => $request['google_address'],
                    'pais_id' => $request['pais_id'],
                    'localidad_id' => $request['localidad_id'],
                    'barrio_id' => $request['barrio_id'],
                ]
            );

            ContactData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'phone' => $request['phone'],
                    'celular' => $request['celular'],
                    'email' => $request['email']
                ]
            );

            SocialData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'tipo_ocupacion_id' => $request['tipo_ocupacion_id'],
                    'cobertura_medica_id' => $request['cobertura_medica_id'],
                    'tipo_pension_id' => $request['tipo_pension_id'],
                    'programa_social_id' => $request['programa_social_id']
                ]
            );

            if (!empty($request['selected_programs'])) {
                $selectedPrograms = explode(',', $request['selected_programs']);
                $person->programaSocial()->sync($selectedPrograms);
            }

            EducationData::updateOrCreate(
                [
                    'person_id' => $person->id
                ],
                [
                    'nivel_educativo_id' => $request['nivel_educativo_id'],
                    'estado_educativo_id' => $request['estado_educativo_id']
                ]
            );

            if ($request['cud']) {
                Cud::updateOrCreate(
                    [
                        'person_id' => $person->id
                    ],
                    [
                        'codigo' => $request['cud'],
                        'diagnostico' => $request['diagnostico']
                    ]
                );
            }

            $status_pendiente = CajasEntrevistasStatus::where('nombre', 'PENDIENTE')->first()->id;

            $observaciones = $request['observaciones'] ? $request['observaciones'] : null;
            $entrevista = CajasEntrevista::updateOrCreate(
                [
                    'person_id' => $person->id,
                    'padron_id' => $request->padron_id
                ],
                [
                    'fecha' => $request['fecha_entrevista'],
                    'entrevistador_id' => $request['entrevistador_id'],
                    'puntos_entrega_id' => $request['sede_id'],
                    'status_id' => $status_pendiente,
                    'created_by' => Auth::user()->id,

                    'vive_solo' => filter_var($request['vive_solo'], FILTER_VALIDATE_BOOLEAN),
                    'cant_convivientes' => $request['cant_convivientes'],
                    'has_hijos' => filter_var($request['has_hijos'], FILTER_VALIDATE_BOOLEAN),
                    'cant_hijos' => $request['cant_hijos'],
                    'cant_personas_trabajando' => $request['cant_trabajadores'],
                    'tenencia' => $request['tenencia'],
                    'pago_inquilino' => $request['pago_inquilino'],
                    'ingresos_trabajo' => $request['ingresos_trabajo'],
                    'ingresos_planes' => $request['ingresos_planes'],

                    'habitacional_tipo_tenencia_id' => $request['tenencia'],
                    'ambientes' => $request['ambientes'],
                    'discapacidad' => filter_var($request['has_discapacidad'], FILTER_VALIDATE_BOOLEAN),

                    'medicacion' => $request['medicacion'],
                    'tratamiento_medico' => $request['tratamiento_medico'],
                    'observaciones' => $observaciones,
                    'conviviente_discapacidad' => filter_var($request['has_discapacidad_conviviente'], FILTER_VALIDATE_BOOLEAN),

                ]
            );

            $entrevista->save();

            // Registrar actividad inicial
            $this->logActivity($entrevista, "Entrevista creada");

            DB::commit();
            Log::info('Entrevista creada correctamente', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Entrevista" => $entrevista->id]);
            return response()->json(['message' => 'Entrevista creada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la entrevista', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    public function list()
    {
        $length = 10;

        $entrevistas = CajasEntrevista::query();

        if (request('name')) {
            $name = request('name');
            $entrevistas->whereHas('person', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $name . '%');
            });
        }

        if (request('num_documento')) {
            $num_documento = str_replace(['.', '-', ' '], '', request('num_documento'));
            // dd($num_documento);
            $entrevistas->whereHas('person', function ($query) use ($num_documento) {
                $query->where('num_documento', $num_documento);
            });
        }

        if (request('date')) {
            $date = json_decode(request('date'));

            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d', strtotime("+1 day", strtotime($date[1])));

            $entrevistas->where('fecha', '>=', $from)
                ->where('fecha', '<', $to);
        }

        if (request('estado')) {
            $estado = request('estado');
            $entrevistas->where('status_id', $estado);
        }

        if (request('punto_entrega_id')) {
            $punto_entrega_id = request('punto_entrega_id');
            $entrevistas->where('puntos_entrega_id', $punto_entrega_id);
        }

        if (request('entrevistador_id')) {
            $entrevistador_id = request('entrevistador_id');
            $entrevistas->where('entrevistador_id', $entrevistador_id);
        }

        if (request('padron_id')) {
            $padron_id = request('padron_id');
            $entrevistas->where('padron_id', $padron_id);
        }


        return $entrevistas
            ->with('padron')
            ->orderBy('fecha', 'DESC')
            ->paginate($length)
            ->withQueryString()
            ->through(fn($entrevista) => [
                'id' => $entrevista->id,
                'fecha' => $entrevista->fecha,
                'person' => $entrevista->person->lastname . ', ' . $entrevista->person->name,
                'num_documento' => $entrevista->person->num_documento,
                'entrevistador' => $entrevista->entrevistador,
                'puntosEntrega' => $entrevista->puntosEntrega,
                'status' => $entrevista->status,
                'status_id' => $entrevista->status_id,
                'padron' => $entrevista->padron
            ]);

    }

    public function edit($id)
    {
        return Inertia::render(
            'Manager/Collections/Entrevistas/Edit',
            [
                'entrevista' => CajasEntrevista::where('id', $id)
                    ->with('person.address')
                    ->with('person.contact')
                    ->with('person.aditional')
                    ->with('person.social')
                    ->with('person.education')
                    ->with('person.programaSocial')
                    ->with('person.cud')
                    ->first(),
                'paises' => Pais::all(),
                'barrios' => Barrio::all(),
                'localidades' => Localidad::all(),
                'canalesAtencion' => CanalAtencion::where('id', '<>', 10)->get(),
                'coberturasMedica' => CoberturaMedica::all(),
                'estadosEducativo' => EstadoEducativo::all(),
                'nivelesEducativo' => NivelEducativo::all(),
                'tiposDocumento' => TipoDocumento::all(),
                'tiposOcupacion' => TipoOcupacion::all(),
                'tiposPension' => TipoPension::all(),
                'tiposVivienda' => TipoVivienda::all(),
                'situacionesConyugal' => SituacionConyugal::all(),
                'rolesTramite' => RolTramite::all(),
                'tiposTramite' => TipoTramite::where('dependencia_id', 5)->active()->get(),
                'programasSocial' => ProgramaSocial::activo()->get(),
                'puntosEntrega' => PuntoEntrega::all(),
                'entrevistadores' => User::whereHas('puntosEntrega')->get(),
                'tipoTenencia' => TipoTenencia::all(),
                'padrones' => Padron::activos()->orderBy('fecha_inicio', 'desc')->get()
            ]
        );
    }

    public function view($id)
    {
        return Inertia::render(
            'Manager/Collections/Entrevistas/Details',
            [
                'entrevista' => CajasEntrevista::where('id', $id)
                    ->with('person.address')
                    ->with('person.contact')
                    ->with('person.aditional')
                    ->with('person.social')
                    ->with('person.education')
                    ->with('person.programaSocial')
                    ->with('person.cud')
                    ->first()
            ]
        );
    }
    public function delete($id)
    {
        // return Inertia::render('Manager/Collections/Entrevistas/Delete', ['id' => $id]);
    }

    /**
     * Update entrevista - Nueva implementación modular
     * Solo actualiza los datos que fueron modificados
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $entrevista = CajasEntrevista::findOrFail($id);

            // Verificar si es solo actualización de estado (modal de suspensión)
            if ($request->has('status_id') && !$request->has('person_id')) {
                $this->updateEntrevistaStatus($entrevista, $request);
                DB::commit();

                return response()->json([
                    'message' => 'Estado actualizado correctamente',
                    'status' => 200
                ]);
            }

            // Actualización completa desde el formulario de edición
            $person = Person::findOrFail($request->person_id);
            $modified = $request->input('modified', []);
            $data = $request->input('data', []);

            // Log para debugging
            Log::info('Datos recibidos para actualizar', [
                'entrevista_id' => $id,
                'person_id' => $request->person_id,
                'modified' => $modified,
                'data' => $data
            ]);

            // Actualizar solo las tablas que fueron modificadas
            if ($modified['entrevista'] ?? false) {
                $this->updateEntrevista($entrevista, $data['entrevista'] ?? []);
            }

            if ($modified['person'] ?? false) {
                $this->updatePerson($person, $data['person'] ?? []);
            }

            if ($modified['address'] ?? false) {
                $this->updateAddress($person, $data['address'] ?? []);
            }

            if ($modified['contact'] ?? false) {
                $this->updateContact($person, $data['contact'] ?? []);
            }

            if ($modified['aditional'] ?? false) {
                $this->updateAditional($person, $data['aditional'] ?? []);
            }

            if ($modified['social'] ?? false) {
                $this->updateSocial($person, $data['social'] ?? []);
            }

            if ($modified['education'] ?? false) {
                $this->updateEducation($person, $data['education'] ?? []);
            }

            if ($modified['cud'] ?? false) {
                $this->updateCud($person, $data['cud'] ?? []);
            }

            if ($modified['programas'] ?? false) {
                $this->updateProgramas($person, $data['programas'] ?? []);
            }

            // Registrar actividad de actualización
            if (array_filter($modified)) {
                $this->logActivity($entrevista, "Actualizó datos de la entrevista");
            }

            DB::commit();

            return response()->json([
                'message' => 'Entrevista actualizada correctamente',
                'status' => 200
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar entrevista: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'message' => 'Error al actualizar la entrevista: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    /**
     * Actualizar solo el estado de la entrevista (usado en modal de suspensión)
     */
    private function updateEntrevistaStatus($entrevista, $request)
    {
            $status_aprobada = CajasEntrevistasStatus::where('nombre', 'APROBADA')->first()->id;
            $status_suspendido = CajasEntrevistasStatus::where('nombre', 'SUSPENDIDO')->first()->id;

        $estadoAnterior = $entrevista->status->nombre;
        $entrevista->status_id = $request->status_id;
            $entrevista->status_updated_by = Auth::user()->id;
            $entrevista->status_updated_at = date('Y-m-d H:i:s');

        $motivoDetalle = '';
            // Si el nuevo estado es SUSPENDIDO, se requiere motivo_suspension_id
        if (intval($request->status_id) == intval($status_suspendido)) {
                if (!$request->has('motivo_suspension_id')) {
                throw new \Exception('El motivo de suspensión es requerido');
                }
            $entrevista->motivo_suspension_id = $request->motivo_suspension_id;
            $motivo = CajasMotivoSuspension::find($request->motivo_suspension_id);
            $motivoDetalle = $motivo ? ", Motivo: {$motivo->description}" : '';
            } else {
                // Si cambia a otro estado, limpiar el motivo de suspensión
                $entrevista->motivo_suspension_id = null;
            }

            $entrevista->save();

        // Registrar cambio de estado en actividades
        $nuevoEstado = CajasEntrevistasStatus::find($request->status_id)->nombre;
        $this->logActivity($entrevista, "Cambió estado de {$estadoAnterior} a {$nuevoEstado}{$motivoDetalle}");

        // Si se aprueba, crear trámite
        if (intval($request->status_id) == intval($status_aprobada)) {
                $this->_createTramite($entrevista);
            }

        Log::info('Estado de la entrevista actualizado correctamente', [
                    "Usuario" => Auth::user()->id . ": " . Auth::user()->name,
                    "Estado" => $entrevista->status->nombre,
                    "Entrevista" => $entrevista->id
                ]);
    }

    /**
     * Actualizar datos de la entrevista (cajas_entrevistas)
     */
    private function updateEntrevista($entrevista, $data)
    {
        $allowedFields = [
            'padron_id', 'entrevistador_id', 'puntos_entrega_id',
            'fecha', 'observaciones', 'vive_solo', 'cant_convivientes',
            'has_hijos', 'cant_hijos', 'cant_personas_trabajando',
            'conviviente_discapacidad', 'tenencia', 'habitacional_tipo_tenencia_id',
            'ambientes', 'ingresos_trabajo', 'ingresos_planes',
            'recibe_tratamiento_medico', 'tratamiento_medico',
            'recibe_medicacion', 'medicacion', 'discapacidad', 'pago_inquilino'
        ];

        $updateData = $this->sanitizeData($data, $allowedFields);

        // Formatear fecha si existe
        if (isset($updateData['fecha'])) {
            $updateData['fecha'] = date('Y-m-d', strtotime($updateData['fecha']));
        }

        // Si tenencia está presente, también actualizar habitacional_tipo_tenencia_id
        if (isset($updateData['tenencia'])) {
            $updateData['habitacional_tipo_tenencia_id'] = $updateData['tenencia'];
        }

        if (!empty($updateData)) {
            $entrevista->update($updateData);
            Log::info('Entrevista actualizada', ['id' => $entrevista->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar datos de la persona (persons)
     */
    private function updatePerson($person, $data)
    {
        $allowedFields = ['name', 'lastname', 'fecha_nac'];
        $updateData = $this->sanitizeData($data, $allowedFields);

        // Formatear fecha si existe
        if (isset($updateData['fecha_nac'])) {
            $updateData['fecha_nac'] = date('Y-m-d', strtotime($updateData['fecha_nac']));
        }

        if (!empty($updateData)) {
            $person->update($updateData);
            Log::info('Person actualizada', ['id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar dirección (address_data)
     */
    private function updateAddress($person, $data)
    {
        $allowedFields = [
            'calle', 'number', 'piso', 'dpto', 'google_address',
            'localidad_id', 'barrio_id', 'latitude', 'longitude', 'pais_id'
        ];

        $updateData = $this->sanitizeData($data, $allowedFields);

        if (!empty($updateData)) {
            AddressData::updateOrCreate(
                ['person_id' => $person->id],
                $updateData
            );
            Log::info('Address actualizada', ['person_id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar contacto (contact_data)
     */
    private function updateContact($person, $data)
    {
        $allowedFields = ['email', 'phone', 'celular'];
        $updateData = $this->sanitizeData($data, $allowedFields);

        if (!empty($updateData)) {
            ContactData::updateOrCreate(
                ['person_id' => $person->id],
                $updateData
            );
            Log::info('Contact actualizada', ['person_id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar datos adicionales (aditional_data)
     */
    private function updateAditional($person, $data)
    {
        $allowedFields = ['situacion_conyugal_id', 'nacionalidad'];
        $updateData = $this->sanitizeData($data, $allowedFields);

        if (!empty($updateData)) {
            AditionalData::updateOrCreate(
                ['person_id' => $person->id],
                $updateData
            );
            Log::info('Aditional actualizada', ['person_id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar datos sociales (social_data)
     */
    private function updateSocial($person, $data)
    {
        $allowedFields = ['tipo_ocupacion_id', 'cobertura_medica_id', 'tipo_pension_id'];
        $updateData = $this->sanitizeData($data, $allowedFields);

        if (!empty($updateData)) {
            SocialData::updateOrCreate(
                ['person_id' => $person->id],
                $updateData
            );
            Log::info('Social actualizada', ['person_id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar educación (education_data)
     */
    private function updateEducation($person, $data)
    {
        $allowedFields = ['nivel_educativo_id', 'estado_educativo_id'];
        $updateData = $this->sanitizeData($data, $allowedFields);

        if (!empty($updateData)) {
            EducationData::updateOrCreate(
                ['person_id' => $person->id],
                $updateData
            );
            Log::info('Education actualizada', ['person_id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar CUD (cud)
     */
    private function updateCud($person, $data)
    {
        $allowedFields = ['codigo', 'diagnostico'];
        $updateData = $this->sanitizeData($data, $allowedFields);

        if (!empty($updateData)) {
            Cud::updateOrCreate(
                ['person_id' => $person->id],
                $updateData
            );
            Log::info('CUD actualizada', ['person_id' => $person->id, 'data' => $updateData]);
        }
    }

    /**
     * Actualizar programas sociales (pivot table)
     */
    private function updateProgramas($person, $programas)
    {
        if (is_array($programas) && !empty($programas)) {
            $person->programaSocial()->sync($programas);
            Log::info('Programas actualizados', ['person_id' => $person->id, 'programas' => $programas]);
        }
    }

    /**
     * Sanitiza los datos: solo incluye campos válidos y con valores no vacíos
     * Para FKs (campos que terminan en _id), valida que sean numéricos
     *
     * @param array $data Los datos a sanitizar
     * @param array $allowedFields Lista de campos permitidos
     * @return array Datos sanitizados
     */
    private function sanitizeData($data, $allowedFields)
    {
        $sanitized = [];

        foreach ($allowedFields as $field) {
            if (!isset($data[$field])) continue;

            $value = $data[$field];

            // Saltar valores null o strings vacíos
            if ($value === null || $value === '') continue;

            // Para campos que terminan en _id (foreign keys), validar que sean numéricos
            if (str_ends_with($field, '_id')) {
                if (!is_numeric($value)) {
                    Log::warning("Campo FK inválido: {$field} con valor no numérico", ['value' => $value]);
                    continue;
                }
                $sanitized[$field] = (int) $value;
            } else {
                // Para otros campos, simplemente asignar el valor
                $sanitized[$field] = $value;
            }
        }

        return $sanitized;
    }

    public function _createTramite($entrevista)
    {

        DB::beginTransaction();
        try {

            $canal_atencion_id = CanalAtencion::where('description', 'SEC. DESARROLLO SOCIAL - SEDE YRIGOYEN')->first()->id;
            $dependencia_id = Dependencia::where('description', 'FORTALECIMIENTO COMUNITARIO')->first()->id;
            $tipo_tramite_id = TipoTramite::where('description', 'EMPADRONAMIENTO CAJAS')->first()->id;

            $tramite_data = Tramite::Create(
                [
                    'fecha' => date("Y-m-d ", strtotime($entrevista->fecha)),
                    'canal_atencion_id' => $canal_atencion_id,
                    'tipo_tramite_id' => $tipo_tramite_id,
                    'dependencia_id' => $dependencia_id,
                    'estado_id' => 1, // Estado Abierto
                ]
            );

            $entrevista->person->tramites()->attach($tramite_data['id'], ['rol_tramite_id' => 1]); // ROL TITULAR

            DB::commit();
            Log::info("Se ha creado un nuevo tramite", ["Modulo" => "Entrevistas:createTramite", "Usuario" => Auth::user()->id . ": " . Auth::user()->name, "ID Tramite" => $tramite_data['id']]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear el tramite', ["Usuario" => Auth::user()->id . ": " . Auth::user()->name, "Error" => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Registra una actividad en el log de la entrevista
     * @param CajasEntrevista $entrevista
     * @param string $detalle
     * @return void
     */
    private function logActivity($entrevista, $detalle)
    {
        $user = Auth::user();
        $fecha = date('d/m/Y H:i');
        $nombreUsuario = $user->name;

        // Obtener actividades existentes
        $actividades = $entrevista->actividades ? $entrevista->actividades . "\n" : '';

        // Agregar nueva actividad
        $nuevaActividad = "[{$fecha}] {$nombreUsuario}: {$detalle}";
        $entrevista->actividades = $actividades . $nuevaActividad;
        $entrevista->save();
    }

}
