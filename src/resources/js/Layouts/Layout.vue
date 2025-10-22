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
              <img class="h-12 w-auto" src="/logo-mvl.png"
                alt="Vicente López" />
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
              <nav class="px-2">
                <div class="space-y-1">
                  <div class="space-y-1">
                    <a :href="route('dashboard')" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
                      <div
                        class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex">
                        <HomeIcon class="w-5 h-5 mr-3" /> <label> Inicio</label>
                      </div>
                    </a>
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
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Discapacidad
                          </li>
                        </a>
                        <a :href="route('entidad')" v-show="store.userCan('ENT', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Entidades
                          </li>
                        </a>
                        <a :href="route('fortalecimiento')" v-show="store.userCan('FOR', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Fortalecimiento Comunitario
                          </li>
                        </a>
                        <a :href="route('genero')" v-show="store.userCan('GEN', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Género y Diversidad
                          </li>
                        </a>
                        <a :href="route('habitat')" v-show="store.userCan('HAB', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Hábitat
                          </li>
                        </a>
                        <a :href="route('ninez')" v-show="store.userCan('NIN', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Niñez y Adolescencia
                          </li>
                        </a>
                        <a :href="route('promocion')" v-show="store.userCan('PPD', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Promoción y Protección de derechos
                          </li>
                        </a>
                        <a :href="route('mayores')" v-show="store.userCan('PM', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Personas Mayores
                          </li>
                        </a>
                        <li class="bg-gray-300 px-2 py-2 my-2 text-sm font-medium rounded-md"
                          v-show="store.userCan('ALL', $page.props.userGroups)">Operativos</li>
                        <a :href="route('vivienda')" v-show="store.userCan('VIV', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
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
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Centros Barriales Infancia
                          </li>
                        </a>
                        <a :href="route('juventud')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Centros Barriales Juventud
                          </li>
                        </a>
                        <hr>
                        <a :href="route('inscripcionCBI')" v-show="store.userCan('CBI', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Inscripción CBI
                          </li>
                        </a>
                        <a :href="route('inscripcionCBJ')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Inscripción CBJ
                          </li>
                        </a>
                        <hr>
                        <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Gabinete
                          </li>
                        </a>
                        <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Mil Dias
                          </li>
                        </a>
                        <hr>
                        <a :href="route('legajoCB')"
                          v-show="store.userCan('CBJ', $page.props.userGroups) || store.userCan('CBI', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
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
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Entrevistas
                          </li>
                        </a>
                        <a :href="route('collections.padron')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Padrón
                          </li>
                        </a>
                        <a :href="route('collections.entregas')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Entregas
                          </li>
                        </a>
                        <a :href="route('collections.puntosEntrega')" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Puntos de Entrega
                          </li>
                        </a>
                        <a :href="route('collections.personal')" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Personal
                          </li>
                        </a>
                        <a :href="route('collections.productos')" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
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
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Usuarios y Permisos
                          </li>
                        </a>

                        <a :href="route('masterdata')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Datos Maestros
                          </li>
                        </a>
                        <a :href="route('logs')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Registro de Logs
                          </li>
                        </a>
                        <a :href="route('import')">
                          <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                            Importador de Registro
                          </li>
                        </a>
                      </DisclosurePanel>

                    </Disclosure>

                    <!-- User Profile Section - Mobile -->
                    <Menu as="div" class="mt-4 pt-4 border-t border-gray-300 relative">
                      <MenuButton class="w-full flex items-center px-2 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <!-- Avatar -->
                        <div class="flex-shrink-0 h-10 w-10 mr-3 rounded-full bg-indigo-100 flex items-center justify-center">
                          <UserIcon class="h-6 w-6 text-indigo-600" />
                        </div>
                        <!-- User Info -->
                        <div class="flex-1 min-w-0 text-left">
                          <!-- <p class="text-xs text-gray-500">Hola,</p> -->
                          <p class="text-sm font-medium text-gray-900 truncate">Hola {{ $page.props.user.name.split(' ')[0] }}</p>
                          <p class="text-xs text-gray-500 truncate">{{ $page.props.user.email }}</p>
                        </div>
                        <!-- Menu Icon -->
                        <EllipsisVerticalIcon class="h-5 w-5 text-gray-400 flex-shrink-0 ml-2" />
                      </MenuButton>

                      <transition
                        enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute top-full mt-2 right-0 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                          <div class="py-1">
                            <MenuItem v-slot="{ active }">
                              <button
                                @click="logout"
                                :class="[
                                  active ? 'bg-red-50 text-red-700' : 'text-gray-700',
                                  'group flex items-center w-full px-4 py-2 text-sm'
                                ]">
                                <PowerIcon class="mr-3 h-5 w-5 text-red-500" />
                                Cerrar Sesión
                              </button>
                            </MenuItem>
                          </div>
                        </MenuItems>
                      </transition>
                    </Menu>
                  </div>
                </div>
                <div class="mt-8">
                  <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider"
                    id="mobile-teams-headline"></h3>
                </div>
              </nav>
            </div>
            <!-- Copyright footer - Mobile -->
            <div class="flex-shrink-0 border-t border-gray-200 p-4">
              <div class="flex flex-col items-center space-y-2">
                <p class="text-xs text-gray-500 text-center">© {{ new Date().getFullYear() }} - Desarrollado por</p>
                <img src="/logo-onmedia.png" alt="OnMedia" class="h-6 w-auto opacity-70" />
              </div>
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
      @mouseenter="handleSidebarHover(true)"
      @mouseleave="handleSidebarHover(false)"
      :class="[
        'hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:border-r lg:border-gray-200 lg:pt-5 lg:pb-4 lg:bg-gray-100 transition-all duration-300 ease-in-out',
        sidebarCollapsed && !sidebarHovered ? 'lg:w-20' : 'lg:w-64',
        sidebarCollapsed && sidebarHovered ? 'lg:shadow-xl' : ''
      ]"
      :style="{ zIndex: sidebarCollapsed && sidebarHovered ? 9999 : 10 }">
      <!-- Logo and Toggle Button -->
      <div :class="[
        'flex-shrink-0 px-4',
        sidebarCollapsed && !sidebarHovered ? '' : 'pb-4 border-b border-gray-200'
      ]">
        <div :class="[
          'flex items-center',
          sidebarCollapsed && !sidebarHovered ? 'justify-center' : 'justify-between'
        ]">
          <a :href="route('dashboard')" class="flex flex-col items-center">
            <img
              :class="[
                'transition-all duration-300',
                sidebarCollapsed && !sidebarHovered ? 'h-10 w-auto' : 'h-12 w-auto'
              ]"
              :src="sidebarCollapsed && !sidebarHovered ? '/logo-mvl-square.png' : '/logo-mvl.png'"
              alt="Vicente López"
            />
            <span
              v-show="!sidebarCollapsed || sidebarHovered"
              class="text-xs text-gray-600 font-bold tracking-wider mt-2 text-center">
              Sec. Desarrollo Social
            </span>
          </a>
          <button
            v-show="!sidebarCollapsed || sidebarHovered"
            @click="toggleSidebar"
            class="p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-200 transition-all duration-200 self-start"
            :title="sidebarCollapsed ? 'Expandir sidebar' : 'Contraer sidebar'"
          >
            <ChevronDoubleLeftIcon v-if="!sidebarCollapsed" class="h-5 w-5" />
            <ChevronDoubleRightIcon v-else class="h-5 w-5" />
          </button>
        </div>
      </div>

      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="mt-6 h-0 flex-1 flex flex-col overflow-y-auto overflow-x-hidden">
        <!-- Navigation -->
        <nav class="px-3 mt-6">

          <div class="space-y-1">
            <a :href="route('dashboard')" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
              <div
                :class="[
                  'w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex items-center',
                  sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                ]"
                :title="sidebarCollapsed && !sidebarHovered ? 'Inicio' : ''">
                <HomeIcon class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                <label v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap"> Inicio</label>
              </div>
            </a>
            <a :href="route('general')" v-show="store.userCan('VUDS-VU', $page.props.userGroups)">
              <div
                :class="[
                  'w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex items-center mt-1',
                  sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                ]"
                :title="sidebarCollapsed && !sidebarHovered ? 'Bandeja General' : ''">
                <InboxIcon class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                <label v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap"> Bandeja General</label>
              </div>
            </a>
            <!-- Render a `div` for the root `Disclosure` component -->
            <Disclosure as="div">
              <!-- Don't render any element (only children) for the `DisclosureButton` component -->
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button
                  :class="[
                    'flex items-center w-full',
                    sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                  ]"
                  :title="sidebarCollapsed && !sidebarHovered ? 'Dependencias' : ''">
                  <Bars3Icon class="flex-shrink-0 h-6 w-6" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                  <span v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap">Dependencias</span>
                </button>
              </DisclosureButton>

              <!-- Render a `ul` for the `DisclosurePanel` component -->
              <DisclosurePanel v-show="!sidebarCollapsed || sidebarHovered" as="ul" class="pl-4">
                <a :href="route('discapacidad')" v-show="store.userCan('DIS', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Discapacidad
                  </li>
                </a>
                <a :href="route('entidad')" v-show="store.userCan('ENT', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Entidades
                  </li>
                </a>
                <a :href="route('fortalecimiento')" v-show="store.userCan('FOR', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Fortalecimiento Comunitario
                  </li>
                </a>
                <a :href="route('genero')" v-show="store.userCan('GEN', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Género y Diversidad
                  </li>
                </a>
                <a :href="route('habitat')" v-show="store.userCan('HAB', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Hábitat
                  </li>
                </a>
                <a :href="route('ninez')" v-show="store.userCan('NIN', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Niñez y Adolescencia
                  </li>
                </a>
                <a :href="route('promocion')" v-show="store.userCan('PPD', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Promoción y Protección de derechos
                  </li>
                </a>
                <a :href="route('mayores')" v-show="store.userCan('PM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Personas Mayores
                  </li>
                </a>
                <li class="bg-gray-300 px-2 py-2 my-2 text-sm font-medium rounded-md"
                  v-show="store.userCan('ALL', $page.props.userGroups)">Operativos</li>
                <a :href="route('vivienda')" v-show="store.userCan('VIV', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Vivienda social
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <Disclosure as="div">
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button
                  :class="[
                    'flex items-center w-full',
                    sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                  ]"
                  :title="sidebarCollapsed && !sidebarHovered ? 'Centros Barriales' : ''">
                  <NewspaperIcon class="flex-shrink-0 h-6 w-6" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                  <span v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap">Centros Barriales</span>
                </button>
              </DisclosureButton>

              <DisclosurePanel v-show="!sidebarCollapsed || sidebarHovered" as="ul" class="pl-4">

                <a :href="route('infancia')" v-show="store.userCan('CBI', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Centros Barriales Infancia
                  </li>
                </a>
                <a :href="route('juventud')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Centros Barriales Juventud
                  </li>
                </a>
                <hr>
                <a :href="route('inscripcionCBI')" v-show="store.userCan('CBI', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Inscripción CBI
                  </li>
                </a>
                <a :href="route('inscripcionCBJ')" v-show="store.userCan('CBJ', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Inscripción CBJ
                  </li>
                </a>
                <hr>
                <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Gabinete
                  </li>
                </a>
                <a :href="route('mil-dias')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Mil Dias
                  </li>
                </a>
                <hr>
                <a :href="route('legajoCB')"
                  v-show="store.userCan('CBJ', $page.props.userGroups) || store.userCan('CBI', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Inscriptos
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <!-- <a :href="route('report')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
              <div
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex mt-1">
                <DocumentChartBarIcon class="w-5 h-5 mr-3" /> <label> Reportes </label>
              </div>
            </a> -->

            <Disclosure as="div" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
                <DisclosureButton as="template" class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                    <button
                      :class="[
                        'flex items-center w-full',
                        sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                      ]"
                      :title="sidebarCollapsed && !sidebarHovered ? 'Reportes' : ''">
                        <DocumentChartBarIcon class="flex-shrink-0 h-6 w-6" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                        <span v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap">Reportes</span>
                    </button>
                </DisclosureButton>

                <DisclosurePanel v-show="!sidebarCollapsed || sidebarHovered" as="ul" class="pl-4">
                    <a :href="route('report')">
                        <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                        Descargar Reporte General
                        </li>
                    </a>
                    <a :href="route('charts')">
                        <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                        Gráfico de Ocupación
                        </li>
                    </a>
                </DisclosurePanel>

            </Disclosure>




            <a :href="route('persons')" v-show="store.userCan('-PROF', $page.props.userGroups)">
              <div
                :class="[
                  'w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex items-center mt-1',
                  sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                ]"
                :title="sidebarCollapsed && !sidebarHovered ? 'Personas' : ''">
                <UserGroupIcon class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                <label v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap"> Personas</label>
              </div>
            </a>

            <a :href="route('downloads')" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
              <div
                :class="[
                  'w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50 flex items-center mt-1',
                  sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                ]"
                :title="sidebarCollapsed && !sidebarHovered ? 'Descargas' : ''">
                <ArrowDownTrayIcon class="w-5 h-5 flex-shrink-0" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                <label v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap"> Descargas</label>
              </div>
            </a>

            <Disclosure as="div" v-show="store.userCan('CAJA', $page.props.userGroups)">
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button
                  :class="[
                    'flex items-center w-full',
                    sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                  ]"
                  :title="sidebarCollapsed && !sidebarHovered ? 'Cajas' : ''">
                  <CubeIcon class="flex-shrink-0 h-6 w-6" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                  <span v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap">Cajas</span>
                </button>
              </DisclosureButton>
              <DisclosurePanel v-show="!sidebarCollapsed || sidebarHovered" as="ul" class="pl-4">
                <a :href="route('collections.entrevistas.index')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Entrevistas
                  </li>
                </a>
                <a :href="route('collections.padron')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Padrón
                  </li>
                </a>
                <hr>
                <a :href="route('collections.entregas')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Entregas
                  </li>
                </a>
                <hr>
                <a :href="route('collections.puntosEntrega')" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Puntos de Entrega
                  </li>
                </a>
                <a :href="route('collections.personal')" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Personal
                  </li>
                </a>
                <a :href="route('collections.productos')" v-show="store.userCan('PROF-CAJA', $page.props.userGroups)">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Productos
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <Disclosure as="div" v-show="store.userCan('ALL-ADM', $page.props.userGroups)">
              <!-- Don't render any element (only children) for the `DisclosureButton` component -->
              <DisclosureButton as="template"
                class="w-full text-gray-900 px-2 py-2 text-sm font-medium rounded-md bg-gray-200 hover:bg-gray-50">
                <button
                  :class="[
                    'flex items-center w-full',
                    sidebarCollapsed && !sidebarHovered ? 'justify-center' : ''
                  ]"
                  :title="sidebarCollapsed && !sidebarHovered ? 'Configuraciones' : ''">
                  <Cog6ToothIcon class="flex-shrink-0 h-6 w-6" :class="sidebarCollapsed && !sidebarHovered ? '' : 'mr-3'" />
                  <span v-show="!sidebarCollapsed || sidebarHovered" class="whitespace-nowrap">Configuraciones</span>
                </button>
              </DisclosureButton>

              <!-- Render a `ul` for the `DisclosurePanel` component -->
              <DisclosurePanel v-show="!sidebarCollapsed || sidebarHovered" as="ul" class="pl-4">

                <a :href="route('users')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Usuarios y Permisos
                  </li>
                </a>

                <a :href="route('masterdata')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Datos Maestros
                  </li>
                </a>
                <a :href="route('logs')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Registro de Logs
                  </li>
                </a>
                <a :href="route('import')">
                  <li class="bg-white px-2 py-2 my-2 text-sm font-medium rounded-md border border-transparent hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-500 transition-all duration-150 cursor-pointer">
                    Importador de Registro
                  </li>
                </a>
              </DisclosurePanel>

            </Disclosure>

            <!-- User Profile Section -->
            <Menu as="div"
              :class="[
                'mt-4 pt-4 border-t border-gray-300 relative',
                sidebarCollapsed && !sidebarHovered ? 'px-2' : 'px-0'
              ]">
              <MenuButton
                :class="[
                  'w-full flex items-center rounded-lg hover:bg-gray-200 transition-colors duration-200',
                  sidebarCollapsed && !sidebarHovered ? 'justify-center p-2' : 'px-2 py-2'
                ]">
                <!-- Avatar -->
                <div
                  :class="[
                    'flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center',
                    sidebarCollapsed && !sidebarHovered ? 'h-10 w-10' : 'h-10 w-10 mr-3'
                  ]">
                  <UserIcon class="h-6 w-6 text-indigo-600" />
                </div>
                <!-- User Info -->
                <div v-show="!sidebarCollapsed || sidebarHovered" class="flex-1 min-w-0 text-left">
                  <!-- <p class="text-xs text-gray-500">Hola,</p> -->
                  <p class="text-sm font-medium text-gray-900 truncate">Hola {{ $page.props.user.name.split(' ')[0] }}</p>
                  <p class="text-xs text-gray-500 truncate">{{ $page.props.user.email }}</p>
                </div>
                <!-- Menu Icon -->
                <EllipsisVerticalIcon
                  v-show="!sidebarCollapsed || sidebarHovered"
                  class="h-5 w-5 text-gray-400 flex-shrink-0 ml-2"
                />
              </MenuButton>

              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95">
                <MenuItems
                  :class="[
                    'absolute top-full mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50',
                    sidebarCollapsed && !sidebarHovered ? 'left-0' : 'right-0'
                  ]">
                  <div class="py-1">
                    <MenuItem v-slot="{ active }">
                      <button
                        @click="logout"
                        :class="[
                          active ? 'bg-red-50 text-red-700' : 'text-gray-700',
                          'group flex items-center w-full px-4 py-2 text-sm'
                        ]">
                        <PowerIcon class="mr-3 h-5 w-5 text-red-500" />
                        Cerrar Sesión
                      </button>
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>
          </div>

        </nav>
      </div>
      <!-- Copyright footer - Desktop -->
      <div class="flex-shrink-0 border-t border-gray-200 p-2">
        <div
          :class="[
            'flex flex-col items-center transition-all duration-300',
            sidebarCollapsed && !sidebarHovered ? 'space-y-1' : 'space-y-2'
          ]">
          <p
            v-show="!sidebarCollapsed || sidebarHovered"
            class="text-xs text-gray-500 text-center whitespace-nowrap">
            © {{ new Date().getFullYear() }} - Desarrollado por
          </p>
          <img
            :src="sidebarCollapsed && !sidebarHovered ? '/logo-onmedia-square.png' : '/logo-onmedia.png'"
            alt="OnMedia"
            :class="[
              'opacity-70 transition-all duration-300',
              sidebarCollapsed && !sidebarHovered ? 'h-auto w-16' : 'h-8 w-auto'
            ]"
            :title="sidebarCollapsed && !sidebarHovered ? '© ' + new Date().getFullYear() + ' - OnMedia' : ''"
          />
        </div>
      </div>
    </div>

    <!-- Main column -->
    <div
      :class="[
        'flex flex-col transition-all duration-300 ease-in-out',
        sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'
      ]">
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

import { ClockIcon, HomeIcon, Bars3CenterLeftIcon, Bars3Icon, XMarkIcon, InboxIcon, Cog6ToothIcon, PowerIcon, DocumentChartBarIcon, NewspaperIcon, ArrowDownTrayIcon, ChevronDoubleLeftIcon, ChevronDoubleRightIcon, UserIcon } from '@heroicons/vue/24/outline'
import { ChevronRightIcon, EllipsisVerticalIcon, MagnifyingGlassIcon, UserGroupIcon, CalendarDaysIcon, CubeIcon } from '@heroicons/vue/24/solid'

import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'

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
    UserIcon,
    UserGroupIcon,
    CalendarDaysIcon,
    NewspaperIcon,
    CubeIcon,
    ArrowDownTrayIcon,
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    HomeIcon,

  },
  setup() {
    const sidebarOpen = ref(false)
    // Cargar el estado del sidebar desde localStorage
    const savedState = localStorage.getItem('sidebarCollapsed')
    const sidebarCollapsed = ref(savedState === 'true')
    const sidebarHovered = ref(false)

    const toggleSidebar = () => {
      sidebarCollapsed.value = !sidebarCollapsed.value
      // Guardar el estado en localStorage
      localStorage.setItem('sidebarCollapsed', sidebarCollapsed.value.toString())
      // Si se expande, resetear el hover
      if (!sidebarCollapsed.value) {
        sidebarHovered.value = false
      }
    }

    const handleSidebarHover = (isHovering) => {
      // Solo aplicar hover si el sidebar está colapsado
      if (sidebarCollapsed.value) {
        sidebarHovered.value = isHovering
      }
    }

    return {
      navigation,
      teams,
      sidebarOpen,
      sidebarCollapsed,
      sidebarHovered,
      toggleSidebar,
      handleSidebarHover,
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
