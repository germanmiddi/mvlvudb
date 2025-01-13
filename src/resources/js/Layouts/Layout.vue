<template>
  <div class="min-h-full">
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
          enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
          leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
          enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform"
          leave-from="translate-x-0" leave-to="-translate-x-full">
          <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
              enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button"
                  class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                  @click="sidebarOpen = false">
                  <span class="sr-only">Close sidebar</span>
                  <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <div class="flex-shrink-0 flex items-center px-4">
              <img class="h-8 w-auto" src="https://www.vicentelopez.gov.ar/assets/images/logo-mvl.png"
                alt="Vicente López" />
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
              <nav class="px-2">
                <div class="space-y-1">
                  <div class="space-y-1">
                    <a :href="route('general')" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
                      <div
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex">
                        <InboxIcon class="w-5 h-5 mr-3" /> <label> Bandeja General</label>
                      </div>
                    </a>
                    <!-- Render a `div` for the root `Disclosure` component -->
                    <Disclosure as="div">
                      <!-- Don't render any element (only children) for the `DisclosureButton` component -->
                      <DisclosureButton as="template"
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                        <button class="flex items-center">
                          <Bars3Icon class="mr-3 flex-shrink-0 h-6 w-6" />Dependencias
                        </button>
                      </DisclosureButton>

                      <!-- Render a `ul` for the `DisclosurePanel` component -->
                      <DisclosurePanel as="ul" class="pl-4">
                        <a :href="route('discapacidad')" v-show="store.userCan('DIS', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Discapacidad
                          </li>
                        </a>
                        <a :href="route('entidad')" v-show="store.userCan('ENT', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Entidades
                          </li>
                        </a>
                        <a :href="route('fortalecimiento')" v-show="store.userCan('FOR', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Fortalecimiento Comunitario
                          </li>
                        </a>
                        <a :href="route('genero')" v-show="store.userCan('GEN', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Género y Diversidad
                          </li>
                        </a>
                        <a :href="route('habitat')" v-show="store.userCan('HAB', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Hábitat
                          </li>
                        </a>
                        <a :href="route('ninez')" v-show="store.userCan('NIN', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Niñez y Adolescencia
                          </li>
                        </a>
                        <a :href="route('promocion')" v-show="store.userCan('PPD', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Promoción y Protección de derechos
                          </li>
                        </a>
                        <a :href="route('mayores')" v-show="store.userCan('PM', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Personas Mayores
                          </li>
                        </a>
                        <li class="bg-gray-300 px-2 py-2 my-2 text-sm font-medium rounded-md"
                          v-show="store.userCan('ALL', $page.props.userGroups)">Operativos</li>
                        <a :href="route('vivienda')" v-show="store.userCan('VIV', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Vivienda social
                          </li>
                        </a>
                      </DisclosurePanel>

                    </Disclosure>

                    <Disclosure as="div">
                      <DisclosureButton as="template"
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                        <button class="flex items-center">
                          <NewspaperIcon class="mr-3 flex-shrink-0 h-6 w-6" />Centros Barriales
                        </button>
                      </DisclosureButton>

                      <DisclosurePanel as="ul" class="pl-4">

                        <a :href="route('infancia')" v-show="store.userCan('CBI', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Centros Barriales Infancia
                          </li>
                        </a>
                        <a :href="route('juventud')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Centros Barriales Juventud
                          </li>
                        </a>
                        <hr>
                        <a :href="route('inscripcionCBI')" v-show="store.userCan('CBI', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Inscripción CBI
                          </li>
                        </a>
                        <a :href="route('inscripcionCBJ')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Inscripción CBJ
                          </li>
                        </a>
                        <hr>
                        <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Gabinete
                          </li>
                        </a>
                        <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Mil Dias
                          </li>
                        </a>
                        <hr>
                        <a :href="route('legajoCB')"
                          v-show="store.userCan('CBJ', $page.props.userGroups) || store.userCan('CBI', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Inscriptos
                          </li>
                        </a>
                      </DisclosurePanel>

                    </Disclosure>

                    <a :href="route('report')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                      <div
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                        <DocumentChartBarIcon class="w-5 h-5 mr-3" /> <label> Reportes </label>
                      </div>
                    </a>

                    <a :href="route('persons')" v-show="store.userCan('-PROF', $page.props.userGroups)">
                      <div
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                        <UserGroupIcon class="w-5 h-5 mr-3" /> <label> Personas</label>
                      </div>
                    </a>

                    <a :href="route('downloads')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                      <div
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                        <ArrowDownTrayIcon class="w-5 h-5 mr-3" /> <label> Descargas</label>
                      </div>
                    </a>

                    <Disclosure as="div" v-show="store.userCan('CAJA', $page.props.userGroups)">
                      <!-- Don't render any element (only children) for the `DisclosureButton` component -->
                      <DisclosureButton as="template"
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                        <button class="flex items-center">
                          <CubeIcon class="mr-3 flex-shrink-0 h-6 w-6" />Cajas
                        </button>
                      </DisclosureButton>
                      <DisclosurePanel as="ul" class="pl-4">
                        <a :href="route('collections.entrevistas.index')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Entrevistas
                          </li>
                        </a>
                        <a :href="route('collections.padron')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Padrón
                          </li>
                        </a>
                        <a :href="route('collections.entregas')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Entregas
                          </li>
                        </a>
                        <a :href="route('collections.puntosEntrega')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Puntos de Entrega
                          </li>
                        </a>
                        <a :href="route('collections.personal')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Personal
                          </li>
                        </a>
                        <a :href="route('collections.productos')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Productos
                          </li>
                        </a>
                      </DisclosurePanel>

                    </Disclosure>

                    <Disclosure as="div" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                      <!-- Don't render any element (only children) for the `DisclosureButton` component -->
                      <DisclosureButton as="template"
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                        <button class="flex items-center">
                          <Cog6ToothIcon class="mr-3 flex-shrink-0 h-6 w-6" />Configuraciones
                        </button>
                      </DisclosureButton>

                      <!-- Render a `ul` for the `DisclosurePanel` component -->
                      <DisclosurePanel as="ul" class="pl-4">

                        <a :href="route('users')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Usuarios y Permisos
                          </li>
                        </a>

                        <a :href="route('masterdata')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Datos Maestros
                          </li>
                        </a>
                        <a :href="route('logs')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Registro de Logs
                          </li>
                        </a>
                        <a :href="route('import')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                            Importador de Registro
                          </li>
                        </a>
                      </DisclosurePanel>

                    </Disclosure>

                    <div
                      class="flex items-center px-2 py-2 hover:text-red-600 hover:bg-gray cursor-pointer text-gray-500 hover:bg-gray-200 rounded-md">
                      <PowerIcon class="mr-3 flex-shrink-0 h-5 w-5" />
                      <span @click="logout" class="text-sm font-medium ">Cerrar Sesión</span>

                    </div>
                  </div>
                </div>
                <div class="mt-8">
                  <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider"
                    id="mobile-teams-headline"></h3>
                </div>
              </nav>
            </div>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div
      class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:border-r lg:border-gray-200 lg:pt-5 lg:pb-4 lg:bg-gray-100">
      <div class="flex items-center flex-shrink-0 px-6 font-bold text-xl">
        <a :href="route('dashboard')">Desarrollo Social</a>
      </div>
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="mt-6 h-0 flex-1 flex flex-col overflow-y-auto">
        <!-- Navigation -->
        <nav class="px-3 mt-6">

          <div class="space-y-1">
            <a :href="route('general')" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
              <div
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex">
                <InboxIcon class="w-5 h-5 mr-3" /> <label> Bandeja General</label>
              </div>
            </a>
            <!-- Render a `div` for the root `Disclosure` component -->
            <Disclosure as="div">
              <!-- Don't render any element (only children) for the `DisclosureButton` component -->
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button class="flex items-center">
                  <Bars3Icon class="mr-3 flex-shrink-0 h-6 w-6" />Dependencias
                </button>
              </DisclosureButton>

              <!-- Render a `ul` for the `DisclosurePanel` component -->
              <DisclosurePanel as="ul" class="pl-4">
                <a :href="route('discapacidad')" v-show="store.userCan('DIS', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Discapacidad
                  </li>
                </a>
                <a :href="route('entidad')" v-show="store.userCan('ENT', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Entidades
                  </li>
                </a>
                <a :href="route('fortalecimiento')" v-show="store.userCan('FOR', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Fortalecimiento Comunitario
                  </li>
                </a>
                <a :href="route('genero')" v-show="store.userCan('GEN', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Género y Diversidad
                  </li>
                </a>
                <a :href="route('habitat')" v-show="store.userCan('HAB', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Hábitat
                  </li>
                </a>
                <a :href="route('ninez')" v-show="store.userCan('NIN', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Niñez y Adolescencia
                  </li>
                </a>
                <a :href="route('promocion')" v-show="store.userCan('PPD', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Promoción y Protección de derechos
                  </li>
                </a>
                <a :href="route('mayores')" v-show="store.userCan('PM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Personas Mayores
                  </li>
                </a>
                <li class="bg-gray-300 px-2 py-2 my-2 text-sm font-medium rounded-md"
                  v-show="store.userCan('ALL', $page.props.userGroups)">Operativos</li>
                <a :href="route('vivienda')" v-show="store.userCan('VIV', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Vivienda social
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <Disclosure as="div">
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button class="flex items-center">
                  <NewspaperIcon class="mr-3 flex-shrink-0 h-6 w-6" />Centros Barriales
                </button>
              </DisclosureButton>

              <DisclosurePanel as="ul" class="pl-4">

                <a :href="route('infancia')" v-show="store.userCan('CBI', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Centros Barriales Infancia
                  </li>
                </a>
                <a :href="route('juventud')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Centros Barriales Juventud
                  </li>
                </a>
                <hr>
                <a :href="route('inscripcionCBI')" v-show="store.userCan('CBI', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Inscripción CBI
                  </li>
                </a>
                <a :href="route('inscripcionCBJ')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Inscripción CBJ
                  </li>
                </a>
                <hr>
                <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Gabinete
                  </li>
                </a>
                <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Mil Dias
                  </li>
                </a>
                <hr>
                <a :href="route('legajoCB')"
                  v-show="store.userCan('CBJ', $page.props.userGroups) || store.userCan('CBI', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Inscriptos
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <a :href="route('report')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
              <div
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                <DocumentChartBarIcon class="w-5 h-5 mr-3" /> <label> Reportes </label>
              </div>
            </a>

            <a :href="route('persons')" v-show="store.userCan('-PROF', $page.props.userGroups)">
              <div
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                <UserGroupIcon class="w-5 h-5 mr-3" /> <label> Personas</label>
              </div>
            </a>

            <a :href="route('downloads')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
              <div
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                <ArrowDownTrayIcon class="w-5 h-5 mr-3" /> <label> Descargas</label>
              </div>
            </a>

            <Disclosure as="div" v-show="store.userCan('CAJA', $page.props.userGroups)">

            
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button class="flex items-center">
                  <CubeIcon class="mr-3 flex-shrink-0 h-6 w-6" />Cajas
                </button>
              </DisclosureButton>
              <DisclosurePanel as="ul" class="pl-4">
                <a :href="route('collections.entrevistas.index')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Entrevistas
                  </li>
                </a>
                <a :href="route('collections.padron')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Padrón
                  </li>
                </a>
                <hr>
                <a :href="route('collections.entregas')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Entregas
                  </li>
                </a>
                <hr>
                <a :href="route('collections.puntosEntrega')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Puntos de Entrega
                  </li>
                </a>
                <a :href="route('collections.personal')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Personal
                  </li>
                </a>
                <a :href="route('collections.productos')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Productos
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <Disclosure as="div" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
              <!-- Don't render any element (only children) for the `DisclosureButton` component -->
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button class="flex items-center">
                  <Cog6ToothIcon class="mr-3 flex-shrink-0 h-6 w-6" />Configuraciones
                </button>
              </DisclosureButton>

              <!-- Render a `ul` for the `DisclosurePanel` component -->
              <DisclosurePanel as="ul" class="pl-4">

                <a :href="route('users')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Usuarios y Permisos
                  </li>
                </a>

                <a :href="route('masterdata')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Datos Maestros
                  </li>
                </a>
                <a :href="route('logs')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Registro de Logs
                  </li>
                </a>
                <a :href="route('import')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md">
                    Importador de Registro
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <div
              class="flex items-center px-2 py-2 hover:text-red-600 hover:bg-gray cursor-pointer text-gray-500 hover:bg-gray-200 rounded-md">
              <PowerIcon class="mr-3 flex-shrink-0 h-5 w-5" />
              <span @click="logout" class="text-sm font-medium ">Cerrar Sesión</span>

            </div>
          </div>

        </nav>
      </div>
    </div>

    <!-- Main column -->
    <div class="lg:pl-64 flex flex-col">
      <!-- Search header -->
      <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-200 lg:hidden">
        <button type="button"
          class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden"
          @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3CenterLeftIcon class="h-6 w-6" aria-hidden="true" />
        </button>
        <div class="flex-1 flex justify-between px-4 sm:px-6 lg:px-8">
          <div class="flex-1 flex">

          </div>
          <div class="flex items-center">
            <div class="text-sm">Hola {{ $page.props.user.name }}<br>
              <span class="text-xs text-gray-400">Sede: Palacio Municipal</span>
            </div>
          </div>
        </div>
      </div>
      <slot> </slot>

    </div>

  </div>
</template>

<script>

import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue'
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'

import { ClockIcon, HomeIcon, Bars3CenterLeftIcon, Bars3Icon, XMarkIcon, InboxIcon, Cog6ToothIcon, PowerIcon, DocumentChartBarIcon, NewspaperIcon, ArrowDownTrayIcon } from '@heroicons/vue/24/outline'
import { ChevronRightIcon, EllipsisVerticalIcon, MagnifyingGlassIcon, ChevronUpDownIcon, UserGroupIcon, CalendarDaysIcon, CubeIcon } from '@heroicons/vue/24/solid'

import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronUpIcon } from '@heroicons/vue/20/solid'

import store from '@/store.js'

const navigation = [
  { name: 'Consultas', href: '#', icon: HomeIcon, current: true },
  { name: 'Alta Trámite', href: '#', icon: HomeIcon, current: true },
  { name: 'Mi Bandeja', href: '#', icon: HomeIcon, current: true },
  { name: 'Usuarios', href: '#', icon: Bars3Icon, current: false },
  { name: 'Configuración', href: '#', icon: ClockIcon, current: false },
]
const teams = [
  { name: 'Engineering', href: '#', bgColorClass: 'bg-indigo-500' },
  { name: 'Human Resources', href: '#', bgColorClass: 'bg-green-500' },
  { name: 'Customer Success', href: '#', bgColorClass: 'bg-yellow-500' },
]


export default {
  components: {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
    ChevronRightIcon,
    EllipsisVerticalIcon,
    Bars3CenterLeftIcon,
    MagnifyingGlassIcon,
    ChevronUpDownIcon,
    Bars3Icon,
    XMarkIcon,
    DocumentChartBarIcon,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    InboxIcon,
    Inertia,
    Cog6ToothIcon,
    PowerIcon,
    UserGroupIcon,
    CalendarDaysIcon,
    NewspaperIcon,
    CubeIcon,
    ArrowDownTrayIcon,

  },
  setup() {
    const sidebarOpen = ref(false)

    return {

      navigation,
      teams,
      // projects,
      // pinnedProjects,
      sidebarOpen,
      store

    }
  },
  data() {
    return {

    }
  },
  methods: {
    logout() {
      this.$inertia.post(route('logout'));
    },

  },


}
</script>
