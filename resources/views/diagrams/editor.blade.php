{{-- resources/views/diagrams/editor.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(isset($diagramId))
            Editor UML - {{ config('app.name') }}
        @else
            Nuevo Diagrama - {{ config('app.name') }}
        @endif
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.3/joint.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased text-pink-950 bg-gradient-to-br from-pink-50 via-rose-50 to-pink-100">
    <div id="app" class="h-screen flex flex-col">

        {{-- Header con navegación (rosado) --}}
        <nav class="bg-white/70 backdrop-blur shadow-sm border-b border-pink-200 px-4 py-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    {{-- Volver --}}
                    <a href="{{ route('diagrams.index') }}"
                       class="flex items-center space-x-2 text-pink-800 hover:text-pink-950 transition-colors">
                        <span class="text-2xl">🏠</span>
                        <span class="font-medium">Mis Diagramas</span>
                    </a>

                    <div class="h-6 w-px bg-pink-200"></div>

                    {{-- Breadcrumb --}}
                    <div class="flex items-center space-x-2 text-sm">
                        <span class="text-pink-700">Editor UML</span>
                        @if(isset($diagramId))
                            <span class="text-pink-400">→</span>
                            <span class="text-pink-950 font-medium" id="diagram-title-nav">
                                Cargando...
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    {{-- Estado guardado --}}
                    <div id="save-status" class="flex items-center space-x-2 text-sm">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full" id="save-indicator"></div>
                        <span id="save-text" class="text-pink-800">Guardado</span>
                    </div>

                    <div class="h-6 w-px bg-pink-200"></div>

                    {{-- Usuario --}}
                    <div class="flex items-center space-x-2">
                        <span class="text-pink-800 text-sm">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-pink-600 hover:text-pink-800 text-sm underline transition-colors">
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Editor principal --}}
        <div class="flex-1 flex flex-col min-h-0">
            @livewire('diagram-editor', ['diagramId' => $diagramId ?? null])
        </div>
    </div>

    {{-- Scripts de auto-guardado (NO TOCAR lógica) --}}
    <script>
        class AutoSaveManager {
            constructor() {
                this.diagramId = {{ $diagramId ?? 'null' }};
                this.autoSaveInterval = 30000;
                this.lastSavedData = '';
                this.autoSaveTimer = null;
                this.isAutoSaving = false;
                this.init();
            }

            init() {
                if (this.diagramId) this.startAutoSave();

                window.addEventListener('diagram-created', (event) => {
                    this.diagramId = event.detail.id;
                    this.startAutoSave();
                    this.updateBreadcrumb();
                });

                this.updateBreadcrumb();
            }

            startAutoSave() {
                if (this.autoSaveTimer) clearInterval(this.autoSaveTimer);

                this.autoSaveTimer = setInterval(() => {
                    this.performAutoSave();
                }, this.autoSaveInterval);
            }

            async performAutoSave() {
                if (this.isAutoSaving || !this.diagramId || !window.DiagramEditor?.instance) return;

                try {
                    const editor = window.DiagramEditor.instance;
                    const currentData = JSON.stringify(editor.graph.toJSON());

                    if (currentData === this.lastSavedData) return;

                    this.isAutoSaving = true;
                    this.updateSaveStatus('saving', 'Auto-guardando...');

                    const response = await fetch(`/diagrams/api/${this.diagramId}/autosave`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ data: currentData })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.lastSavedData = currentData;
                        this.updateSaveStatus('saved', 'Auto-guardado');
                    } else {
                        throw new Error(result.error || 'Error en auto-save');
                    }

                } catch (error) {
                    this.updateSaveStatus('error', 'Error auto-guardado');
                } finally {
                    this.isAutoSaving = false;
                }
            }

            updateSaveStatus(status, text) {
                const indicator = document.getElementById('save-indicator');
                const textEl = document.getElementById('save-text');
                if (!indicator || !textEl) return;

                switch (status) {
                    case 'saving':
                        indicator.className = 'w-2 h-2 bg-amber-500 rounded-full animate-pulse';
                        break;
                    case 'saved':
                        indicator.className = 'w-2 h-2 bg-emerald-500 rounded-full';
                        break;
                    case 'error':
                        indicator.className = 'w-2 h-2 bg-rose-500 rounded-full';
                        break;
                }

                textEl.textContent = text;
            }

            async updateBreadcrumb() {
                const titleEl = document.getElementById('diagram-title-nav');
                if (!this.diagramId) {
                    if (titleEl) titleEl.textContent = 'Nuevo Diagrama';
                    return;
                }

                try {
                    const response = await fetch(`/diagrams/api/${this.diagramId}/stats`);
                    const data = await response.json();

                    if (titleEl && data.title) {
                        titleEl.textContent = data.title;
                        document.title = `${data.title} - Editor UML`;
                    }
                } catch (error) {}
            }

            forceSave() {
                if (this.diagramId && window.DiagramEditor?.instance) {
                    const editor = window.DiagramEditor.instance;
                    const currentData = JSON.stringify(editor.graph.toJSON());
                    window.Livewire.dispatch('save-diagram', [currentData]);
                }
            }

            stop() {
                if (this.autoSaveTimer) clearInterval(this.autoSaveTimer);
                this.autoSaveTimer = null;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            window.AutoSaveManager = new AutoSaveManager();

            document.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    window.AutoSaveManager.forceSave();
                }
            });
        });

        window.addEventListener('beforeunload', () => {
            if (window.AutoSaveManager) window.AutoSaveManager.stop();
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
