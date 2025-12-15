{{-- resources/views/diagrams/shared.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $diagram->title }} - Diagrama Compartido</title>
    <meta name="description" content="{{ $diagram->description ?? 'Diagrama UML compartido' }}">

    <meta property="og:title" content="{{ $diagram->title }}">
    <meta property="og:description" content="{{ $diagram->description ?? 'Diagrama UML compartido' }}">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.3/joint.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-pink-950">
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-pink-50 via-rose-50 to-pink-100">

        <!-- Header -->
        <nav class="bg-white/70 backdrop-blur shadow-sm border-b border-pink-200 px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">📊</span>
                        <div>
                            <h1 class="text-lg font-semibold text-pink-950">{{ $diagram->title }}</h1>
                            @if($diagram->description)
                                <p class="text-sm text-pink-800">{{ $diagram->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-4 text-sm text-pink-700">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-pink-500 rounded-full mr-1"></span>
                            {{ $diagram->elements_count }} elementos
                        </span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-rose-500 rounded-full mr-1"></span>
                            {{ $diagram->classes_count }} clases
                        </span>
                        <span class="text-xs text-pink-600/70">
                            por {{ $diagram->user->name }}
                        </span>
                    </div>

                    <div class="flex space-x-2">
                        @auth
                            <form method="POST" action="{{ route('diagrams.duplicate', $diagram->id) }}">
                                @csrf
                                <button type="submit"
                                        class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
                                    📋 Clonar a mis diagramas
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                               class="bg-pink-600 hover:bg-pink-700 text-white px-3 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
                                Iniciar sesión para clonar
                            </a>
                        @endauth

                        <button onclick="exportDiagram('png')"
                                class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
                            📷 Exportar PNG
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Visor -->
        <div class="flex-1 flex">
            <div class="flex-1 relative">
                <div id="paper-container" class="w-full h-full relative bg-white/40">
                    <!-- render -->
                </div>

                <div class="absolute top-4 left-4 bg-white/80 backdrop-blur px-4 py-2 rounded-xl shadow-sm border border-pink-200">
                    <div class="text-sm text-pink-700">
                        <div class="font-semibold text-pink-900">Modo visualización</div>
                        <div class="text-xs mt-1">Solo lectura • Usa zoom y pan para navegar</div>
                    </div>
                </div>

                <div class="absolute bottom-4 right-4 flex flex-col space-y-2">
                    <button id="zoom-in"
                            class="bg-white/85 hover:bg-white border border-pink-200 p-2 rounded-xl shadow-sm transition-colors"
                            title="Acercar">
                        🔍+
                    </button>
                    <button id="zoom-out"
                            class="bg-white/85 hover:bg-white border border-pink-200 p-2 rounded-xl shadow-sm transition-colors"
                            title="Alejar">
                        🔍-
                    </button>
                    <button id="zoom-fit"
                            class="bg-white/85 hover:bg-white border border-pink-200 p-2 rounded-xl shadow-sm transition-colors"
                            title="Ajustar al contenido">
                        ⬜
                    </button>
                </div>
            </div>

            <div class="w-80 bg-white/80 backdrop-blur shadow-sm border-l border-pink-200 overflow-y-auto">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-pink-950 mb-4">Información del Diagrama</h3>

                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-pink-700">Creado por</dt>
                            <dd class="text-sm text-pink-950">{{ $diagram->user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-pink-700">Creado</dt>
                            <dd class="text-sm text-pink-950">{{ $diagram->created_at->format('d/m/Y H:i') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-pink-700">Última actualización</dt>
                            <dd class="text-sm text-pink-950">{{ $diagram->last_saved_at?->diffForHumans() ?? 'No disponible' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-pink-700">Versión</dt>
                            <dd class="text-sm text-pink-950">{{ $diagram->version }}</dd>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-pink-200">
                        <h4 class="text-md font-semibold text-pink-950 mb-3">Estadísticas</h4>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 bg-pink-50 rounded-xl border border-pink-200">
                                <div class="text-2xl font-bold text-pink-700">{{ $diagram->elements_count }}</div>
                                <div class="text-xs text-pink-700">Elementos totales</div>
                            </div>

                            <div class="text-center p-3 bg-rose-50 rounded-xl border border-rose-200">
                                <div class="text-2xl font-bold text-rose-700">{{ $diagram->classes_count }}</div>
                                <div class="text-xs text-rose-700">Clases</div>
                            </div>

                            <div class="text-center p-3 bg-fuchsia-50 rounded-xl border border-fuchsia-200">
                                <div class="text-2xl font-bold text-fuchsia-700">{{ $diagram->relationships_count }}</div>
                                <div class="text-xs text-fuchsia-700">Relaciones</div>
                            </div>

                            <div class="text-center p-3 bg-orange-50 rounded-xl border border-orange-200">
                                <div class="text-2xl font-bold text-orange-700">{{ $diagram->version }}</div>
                                <div class="text-xs text-orange-700">Versión</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-pink-200">
                        <h4 class="text-md font-semibold text-pink-950 mb-3">Navegación</h4>
                        <div class="space-y-2 text-sm text-pink-800">
                            <div class="flex justify-between">
                                <span>Zoom</span>
                                <code class="bg-white/70 px-2 py-1 rounded text-xs border border-pink-200">Scroll del mouse</code>
                            </div>
                            <div class="flex justify-between">
                                <span>Pan</span>
                                <code class="bg-white/70 px-2 py-1 rounded text-xs border border-pink-200">Click y arrastra</code>
                            </div>
                            <div class="flex justify-between">
                                <span>Ajustar</span>
                                <code class="bg-white/70 px-2 py-1 rounded text-xs border border-pink-200">Botón ⬜</code>
                            </div>
                        </div>
                    </div>

                    @auth
                        <div class="mt-6 pt-6 border-t border-pink-200">
                            <h4 class="text-md font-semibold text-pink-950 mb-3">Acciones</h4>
                            <div class="space-y-3">
                                <form method="POST" action="{{ route('diagrams.duplicate', $diagram->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
                                        📋 Clonar a mis diagramas
                                    </button>
                                </form>

                                <a href="{{ route('diagrams.index') }}"
                                   class="block w-full bg-white/90 hover:bg-white text-pink-800 px-4 py-2 rounded-xl text-sm font-medium text-center transition-colors border border-pink-200 shadow-sm">
                                    🏠 Ver mis diagramas
                                </a>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </div>

    <script>
        const diagramData = @json($diagram->data);

        class DiagramViewer {
            constructor() {
                this.graph = new joint.dia.Graph();
                this.paper = null;
                this.currentZoom = 1;
                this.init();
            }

            init() {
                this.createPaper();
                this.setupEventListeners();
                this.loadDiagram();
            }

            createPaper() {
                const container = document.getElementById('paper-container');
                if (!container) return;

                this.paper = new joint.dia.Paper({
                    el: container,
                    model: this.graph,
                    width: '100%',
                    height: '100%',
                    gridSize: 20,
                    drawGrid: true,
                    background: { color: '#fff7f9' },
                    interactive: false,
                    mouseWheelZoom: true
                });
            }

            setupEventListeners() {
                document.getElementById('zoom-in')?.addEventListener('click', () => this.zoomIn());
                document.getElementById('zoom-out')?.addEventListener('click', () => this.zoomOut());
                document.getElementById('zoom-fit')?.addEventListener('click', () => this.zoomToFit());
            }

            loadDiagram() {
                if (diagramData && diagramData.cells) {
                    try {
                        this.graph.fromJSON(diagramData);
                        setTimeout(() => this.zoomToFit(), 100);
                    } catch (error) {
                        console.error('❌ Error cargando diagrama:', error);
                    }
                }
            }

            zoomIn() {
                this.currentZoom = Math.min(3, this.currentZoom + 0.1);
                this.paper.scale(this.currentZoom, this.currentZoom);
            }

            zoomOut() {
                this.currentZoom = Math.max(0.2, this.currentZoom - 0.1);
                this.paper.scale(this.currentZoom, this.currentZoom);
            }

            zoomToFit() {
                this.paper.scaleContentToFit({ padding: 20 });
                this.currentZoom = this.paper.scale().sx;
            }
        }

        function exportDiagram(format) {
            if (format === 'png') {
                alert('Funcionalidad de exportación próximamente. Por ahora usa clic derecho > Guardar imagen.');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new DiagramViewer();
        });
    </script>
</body>
</html>
