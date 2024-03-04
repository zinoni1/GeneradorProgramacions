@extends('master')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
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
    events: {!! json_encode($cursos) !!}
    })
    calendar.render()
  })
</script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
