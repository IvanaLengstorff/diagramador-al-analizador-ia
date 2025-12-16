{{-- resources/views/diagrams/show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $diagram->title }} - Ver diagrama</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- ✅ SOLO CSS (NO app.js para que no se cargue tu editor/IA) -->
    @vite(['resources/css/app.css'])

    <!-- JointJS CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.3/joint.css" />

    <!-- ✅ Dependencias en ORDEN correcto -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.1/backbone-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.7.3/joint.min.js"></script>
</head>

<body class="font-sans antialiased text-pink-950">
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-rose-50 to-pink-100 flex flex-col">

    <!-- HEADER -->
    <header class="border-b border-pink-200 bg-white/60 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('diagrams.index') }}"
               class="text-pink-800 hover:text-pink-900 font-medium">
                ← Volver a Mis Diagramas
            </a>

            <div class="text-center">
                <div class="font-semibold text-pink-900">{{ $diagram->title }}</div>
                <div class="text-xs text-pink-700">
                    Modo visualización (solo lectura) • Pan: arrastrar • Zoom: rueda o botones
                </div>
            </div>

            <!-- Controles zoom -->
            <div class="flex items-center gap-2">
                <button id="zoom-out"
                        class="px-3 py-2 rounded-xl bg-white/70 border border-pink-200 shadow-sm hover:bg-white transition"
                        title="Alejar">−</button>

                <button id="zoom-fit"
                        class="px-4 py-2 rounded-xl bg-white/70 border border-pink-200 shadow-sm hover:bg-white transition"
                        title="Ajustar al contenido">Ajustar</button>

                <button id="zoom-in"
                        class="px-3 py-2 rounded-xl bg-white/70 border border-pink-200 shadow-sm hover:bg-white transition"
                        title="Acercar">+</button>
            </div>
        </div>
    </header>

    <!-- CANVAS GRANDE -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-6 py-6 h-full">
            <div class="rounded-3xl border border-pink-200 bg-white/70 shadow-xl overflow-hidden h-[calc(100vh-160px)]">
                <div id="paper-container" class="w-full h-full"></div>
            </div>
        </div>
    </main>
</div>

<script>
    // ✅ Debug rápido: debería imprimir "true"
    console.log('✅ jQuery:', !!window.jQuery, ' lodash:', !!window._, ' backbone:', !!window.Backbone, ' joint:', !!window.joint);

    // ✅ Datos del diagrama (robusto: si viene string, lo parsea)
    let diagramData = @json($diagram->data);

    try {
        if (typeof diagramData === 'string') {
            diagramData = JSON.parse(diagramData);
        }
    } catch (e) {
        console.error('❌ No se pudo parsear $diagram->data.', e);
        diagramData = null;
    }

    class DiagramShowViewer {
        constructor() {
            if (!window.joint || !window.joint.dia) {
                console.error('❌ JointJS no cargó (window.joint no disponible)');
                return;
            }

            this.graph = new joint.dia.Graph();
            this.paper = null;
            this.currentZoom = 1;

            this.init();
        }

        init() {
            this.createPaper();
            this.setupZoomButtons();
            this.loadDiagram();
        }

        createPaper() {
            const container = document.getElementById('paper-container');
            if (!container) return;

            this.paper = new joint.dia.Paper({
                el: container,
                model: this.graph,
                width: container.clientWidth,
                height: container.clientHeight,
                gridSize: 20,
                drawGrid: true,
                background: { color: '#fff7f9' },
                interactive: false,
                async: true
            });

            // ✅ Pan con arrastre
            let panning = false;
            let panStart = { x: 0, y: 0 };
            let originStart = { tx: 0, ty: 0 };

            const paperEl = this.paper.el;

            paperEl.addEventListener('mousedown', (e) => {
                panning = true;
                panStart = { x: e.clientX, y: e.clientY };
                originStart = this.paper.translate();
            });

            window.addEventListener('mousemove', (e) => {
                if (!panning) return;
                const dx = e.clientX - panStart.x;
                const dy = e.clientY - panStart.y;
                this.paper.translate(originStart.tx + dx, originStart.ty + dy);
            });

            window.addEventListener('mouseup', () => {
                panning = false;
            });

            // ✅ Zoom con rueda
            paperEl.addEventListener('wheel', (e) => {
                e.preventDefault();
                const delta = e.deltaY < 0 ? 0.1 : -0.1;
                this.setZoom(this.currentZoom + delta);
            }, { passive: false });

            // ✅ Resize
            window.addEventListener('resize', () => {
                const c = document.getElementById('paper-container');
                if (!c || !this.paper) return;
                this.paper.setDimensions(c.clientWidth, c.clientHeight);
            });
        }

        setupZoomButtons() {
            document.getElementById('zoom-in')?.addEventListener('click', () => this.setZoom(this.currentZoom + 0.1));
            document.getElementById('zoom-out')?.addEventListener('click', () => this.setZoom(this.currentZoom - 0.1));
            document.getElementById('zoom-fit')?.addEventListener('click', () => this.zoomToFit());
        }

        loadDiagram() {
            if (!diagramData) {
                console.warn('⚠️ diagramData es null');
                return;
            }

            // A veces puede venir como { cells: [...] } o directamente como array
            const normalized = Array.isArray(diagramData)
                ? { cells: diagramData }
                : diagramData;

            if (!normalized.cells) {
                console.warn('⚠️ diagramData no tiene "cells".', normalized);
                return;
            }

            try {
                this.graph.fromJSON(normalized);
                setTimeout(() => this.zoomToFit(), 50);
                console.log('✅ Diagrama renderizado:', normalized.cells.length, 'elementos');
            } catch (error) {
                console.error('❌ Error renderizando diagrama:', error);
            }
        }

        setZoom(value) {
            const z = Math.max(0.2, Math.min(3, value));
            this.currentZoom = z;
            this.paper.scale(z, z);
        }

        zoomToFit() {
            if (!this.paper) return;
            this.paper.scaleContentToFit({ padding: 30 });
            this.currentZoom = this.paper.scale().sx;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        new DiagramShowViewer();
    });
</script>

</body>
</html>
