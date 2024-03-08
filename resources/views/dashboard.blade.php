@extends('master')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            let currentCurso = null; // Almacena el curso seleccionado actualmente

            const calendar = new FullCalendar.Calendar(calendarEl, {
                // Configuración del calendario...
                initialView: 'dayGridMonth',
                slotMinTime: '08:00',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,dayGridMonth'
                },
                events: {!! json_encode($cursos) !!}
            });
            calendar.render();

function updateCalendar(cursoId) {

    calendar.getEvents().forEach(event => event.remove());

    if (!cursoId) {
        {!! json_encode($cursos) !!}.forEach(curso => {
            calendar.addEvent({
                title: curso.title,
                start: curso.start,
                color: curso.color
            });
        });
        return;
    }

    const eventosCurso = {!! $allcursos->toJson() !!}.filter(curso => curso.id == cursoId);

    eventosCurso.forEach(curso => {
        calendar.addEvent({
            title: curso.nom + ' (Inicio)',
            start: curso.data_inici,
            color: '#FF5733'
        });

        calendar.addEvent({
            title: curso.nom + ' (Fin)',
            start: curso.data_final,
            color: '#FF5733'
        });
    });
}

            document.getElementById('curso_select').addEventListener('change', function() {
                const selectedCurso = this.value;

                if (selectedCurso !== currentCurso) {
                    currentCurso = selectedCurso;
                    updateCalendar(selectedCurso);
                }
            });
        });
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <select id="curso_select" class="mb-3">
                        <option value="">Selecciona un curs</option>
                        @foreach($allcursos as $curs)
                            <option value="{{ $curs->id }}">{{ $curs->nom }}</option>
                        @endforeach
                    </select>

                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
