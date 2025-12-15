<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-pink-950 leading-tight">
                {{ __('Mis Diagramas UML') }}
            </h2>

            <a href="{{ route('diagrams.editor') }}"
               class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl font-medium transition-colors inline-flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M11 5h2v14h-2V5zm-6 6h14v2H5v-2z"/>
                </svg>
                Nuevo Diagrama
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Estadísticas rápidas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

                <!-- Total -->
                <div class="bg-white/70 backdrop-blur overflow-hidden shadow-sm sm:rounded-2xl border border-pink-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-pink-100 border border-pink-200 rounded-2xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-pink-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M4 19h16v2H4v-2zM6 10h3v7H6v-7zm5-4h3v11h-3V6zm5 2h3v9h-3V8z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-pink-700 truncate">Total</dt>
                                    <dd class="text-lg font-semibold text-pink-950">{{ $stats['total'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privados -->
                <div class="bg-white/70 backdrop-blur overflow-hidden shadow-sm sm:rounded-2xl border border-pink-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-rose-100 border border-rose-200 rounded-2xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-rose-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 1a5 5 0 00-5 5v3H6a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2v-9a2 2 0 00-2-2h-1V6a5 5 0 00-5-5zm-3 8V6a3 3 0 016 0v3H9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-pink-700 truncate">Privados</dt>
                                    <dd class="text-lg font-semibold text-pink-950">{{ $stats['private'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compartidos -->
                <div class="bg-white/70 backdrop-blur overflow-hidden shadow-sm sm:rounded-2xl border border-pink-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-fuchsia-100 border border-fuchsia-200 rounded-2xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-fuchsia-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.96 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-pink-700 truncate">Compartidos</dt>
                                    <dd class="text-lg font-semibold text-pink-950">{{ $stats['shared'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Templates -->
                <div class="bg-white/70 backdrop-blur overflow-hidden shadow-sm sm:rounded-2xl border border-pink-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 border border-orange-200 rounded-2xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M6 2h9l5 5v15a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zm8 1.5V8h4.5L14 3.5zM8 12h8v2H8v-2zm0 4h8v2H8v-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-pink-700 truncate">Templates</dt>
                                    <dd class="text-lg font-semibold text-pink-950">{{ $stats['templates'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Filtros y búsqueda --}}
            <div class="bg-white/70 backdrop-blur shadow-sm sm:rounded-2xl mb-6 border border-pink-200">
                <div class="p-6">
                    <form method="GET" action="{{ route('diagrams.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
                        <div class="flex-1">
                            <input type="text"
                                   name="search"
                                   value="{{ $filters['search'] }}"
                                   placeholder="Buscar por título o descripción..."
                                   class="block w-full border-pink-200 rounded-xl shadow-sm focus:border-pink-400 focus:ring-pink-400 sm:text-sm">
                        </div>

                        <div>
                            <select name="visibility"
                                    class="border-pink-200 rounded-xl shadow-sm focus:border-pink-400 focus:ring-pink-400 sm:text-sm">
                                <option value="">Todas las visibilidades</option>
                                <option value="private" {{ $filters['visibility'] === 'private' ? 'selected' : '' }}>Privados</option>
                                <option value="shared" {{ $filters['visibility'] === 'shared' ? 'selected' : '' }}>Compartidos</option>
                                <option value="public" {{ $filters['visibility'] === 'public' ? 'selected' : '' }}>Públicos</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="templates"
                                   id="templates"
                                   value="1"
                                   {{ $filters['is_template'] ? 'checked' : '' }}
                                   class="h-4 w-4 text-pink-600 border-pink-200 rounded focus:ring-pink-400">
                            <label for="templates" class="ml-2 text-sm text-pink-800">Solo templates</label>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit"
                                    class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors inline-flex items-center gap-2">
                                <span>Filtrar</span>
                            </button>

                            <a href="{{ route('diagrams.index') }}"
                               class="bg-white hover:bg-pink-50 border border-pink-200 text-pink-800 px-4 py-2 rounded-xl text-sm font-medium transition-colors inline-flex items-center gap-2">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Lista de diagramas --}}
            @if($diagrams->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($diagrams as $diagram)
                        <div class="bg-white/70 backdrop-blur overflow-hidden shadow-sm sm:rounded-2xl border border-pink-200 hover:shadow-md transition-shadow">
                            <div class="p-6">

                                {{-- Header del diagrama --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-pink-950 truncate">
                                            {{ $diagram->title }}
                                        </h3>
                                        @if($diagram->description)
                                            <p class="mt-1 text-sm text-pink-800 line-clamp-2">
                                                {{ Str::limit($diagram->description, 100) }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Indicador de visibilidad --}}
                                    <div class="ml-4 flex-shrink-0">
                                        @if($diagram->visibility === 'private')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-900 border border-pink-200">
                                                🔒 Privado
                                            </span>
                                        @elseif($diagram->visibility === 'shared')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-fuchsia-100 text-fuchsia-900 border border-fuchsia-200">
                                                🤝 Compartido
                                            </span>
                                        @elseif($diagram->visibility === 'public')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-900 border border-emerald-200">
                                                🌍 Público
                                            </span>
                                        @endif

                                        @if($diagram->is_template)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-900 border border-orange-200 ml-2">
                                                📝 Template
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Estadísticas del diagrama --}}
                                <div class="flex items-center text-sm text-pink-700 space-x-4 mb-4">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 bg-pink-500 rounded-full mr-1"></span>
                                        {{ $diagram->elements_count }} elementos
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 bg-rose-500 rounded-full mr-1"></span>
                                        {{ $diagram->classes_count }} clases
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 bg-fuchsia-500 rounded-full mr-1"></span>
                                        v{{ $diagram->version }}
                                    </span>
                                </div>

                                {{-- Fechas --}}
                                <div class="text-xs text-pink-600/80 mb-4">
                                    <div>Creado: {{ $diagram->created_at->format('d/m/Y H:i') }}</div>
                                    @if($diagram->last_saved_at)
                                        <div>Guardado: {{ $diagram->last_saved_at->diffForHumans() }}</div>
                                    @endif
                                </div>

                                {{-- Botones de acción --}}
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('diagrams.editor', $diagram->id) }}"
                                       class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                        ✏️ Editar
                                    </a>

                                    <a href="{{ route('diagrams.show', $diagram->id) }}"
                                       class="bg-white hover:bg-pink-50 border border-pink-200 text-pink-800 px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                        👁️ Ver
                                    </a>

                                    <form method="POST" action="{{ route('diagrams.duplicate', $diagram->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                            📋 Clonar
                                        </button>
                                    </form>

                                    @if($diagram->user_id === auth()->id())
                                        <form method="POST" action="{{ route('diagrams.destroy', $diagram->id) }}"
                                              class="inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este diagrama?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                <div class="mt-6">
                    {{ $diagrams->appends(request()->query())->links() }}
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="bg-white/70 backdrop-blur shadow-sm sm:rounded-2xl border border-pink-200">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto bg-pink-100 border border-pink-200 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-pink-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M4 19h16v2H4v-2zM6 10h3v7H6v-7zm5-4h3v11h-3V6zm5 2h3v9h-3V8z"/>
                            </svg>
                        </div>

                        <h3 class="text-lg font-semibold text-pink-950 mb-2">No tienes diagramas aún</h3>
                        <p class="text-pink-800 mb-6">Comienza creando tu primer diagrama de clases UML</p>

                        <a href="{{ route('diagrams.editor') }}"
                           class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-xl font-medium transition-colors inline-flex items-center gap-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M11 5h2v14h-2V5zm-6 6h14v2H5v-2z"/>
                            </svg>
                            Crear mi primer diagrama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
