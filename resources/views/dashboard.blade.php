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
        {!! json_encode($cursos) !!}.forEach(evento => {
            calendar.addEvent({
                title: evento.title,
                start: evento.start,
                end: evento.end,
                color: evento.color
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

// Filtrar trimestres por curso seleccionado
trimestres = {!! json_encode($allTrimestres) !!}.filter(trimestre => trimestre.curso_id == cursoId);
console.log("Trimestres filtrados:", trimestres);

// Agregar trimestres por curso especifico con su ID
trimestres.forEach(trimestre => {
    calendar.addEvent({
        title: trimestre.nom + ' (Inicio)',
        start: trimestre.data_inici,
        color: '#0000FF'
    });


    calendar.addEvent({
        title: trimestre.nom + ' (Fin)',
        start: trimestre.data_final,
        color: '#0000FF'
    });
});

    //agrega festivos por curso especifico con su id
    festius = {!! json_encode($allFestius) !!}.filter(festiu => festiu.curs_id == cursoId);
    //agrega festivos por curso especifico con su id
festius.forEach(festiu => {
    calendar.addEvent({
        title: festiu.nom,
        start: festiu.data_inici,
        end: festiu.data_final,
        color: '#BDECB6',
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
                    <select id="curso_select" class="mb-">
                        <option value="">Tots</option>
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
