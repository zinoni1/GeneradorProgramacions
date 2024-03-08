@extends('master')

@section('content')
    <div class="py-6"> 
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 text-center"> 
                    <h2 class="text-lg font-bold">{{ $cicle->nom }} - {{ $modul->nom }}</h2> 
                    <div id="calendar" class="mt-4"></div> 
                    <a href="{{ route('dashboard') }}" class="btn btn-primary float-left mt-4">Tornar al Dashboard</a> 
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                slotMinTime: '08:00',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,dayGridMonth'
                },
                events: {!! json_encode($events) !!},
            })
            calendar.render()
        })
    </script>
@endsection
