@extends('welcome')
@section('calculation')
    <div class="container max-w-full p-12">
        <div class="search">
            <label>
                <input class="not-clearable"
                       id="search"
                       type="search"
                       placeholder="Search records"
                       aria-controls="calculation_table"
                >
            </label>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 shadow-md sm:rounded-lg"
               id="calculationTable" data-route-calculation="{{ route('drivers') }}"
               data-route-action="{{ route('calculated-trips') }}">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="text-center">
                <th scope="col"
                    class="px-6 py-3 sorting_asc" data-id="driver_id" data-table="calculation">Driver_id</th>
                <th scope="col">Payable Time (minutes)</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div>
            <ul id="pagination" class="pagination-sm"></ul>
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script type="text/javascript" src="{{ asset('/resources/trips.js') }}"></script>
@endpush