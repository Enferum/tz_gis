jQuery().ready(function () {
    const $table = $('#customTable')
    const $calculationTable = $('#calculationTable')
    const route = $table.data('route')
    const calculation_route = $calculationTable.data('route-calculation')
    let search = '';
    const $pagination = $('#pagination')
    let currentPage = 1;
    let timeout = null;
    let sort = 'driver_id'
    let delimiter = 'asc'

    getItems();
    getCalculation();

    function getItems() {
        let data = {currentPage, search: search, sort, delimiter}
        $.ajax({
            type: 'GET',
            url: route,
            data: data,
            dataType: 'json',
            success: function (response) {
                $table.find('tbody').html('')
                const trips = response.data
                trips.forEach(trip => {
                    $table.find('tbody').append(
                        $('<tr>').addClass('text-center')
                            .append($('<td>').append(trip.id))
                            .append($('<td>').append(trip.driver_id))
                            .append($('<td>').append(trip.pickup))
                            .append($('<td>').append(trip.dropoff))
                    )
                })
                pagination(response.meta)
            }
        })
    }

    function getCalculation() {
        let data = {currentPage, search: search, sort, delimiter}
        $.ajax({
            type: 'GET',
            url: calculation_route,
            data: data,
            dataType: 'json',
            success: function (response) {
                $calculationTable.find('tbody').html('')
                const calculations = response.data
                calculations.forEach(calculation => {
                    $calculationTable.find('tbody').append(
                        $('<tr>').addClass('text-center')
                            .append($('<td>').append(calculation.driver_id))
                            .append($('<td>').append(calculation.total_minutes_with_passenger).attr('id', calculation.driver_id))
                            .append(
                                $('<td>').append(
                                    $('<button>')
                                        .addClass('action-button')
                                        .attr('data-id', calculation.driver_id)
                                        .text('calculate')
                                )
                            )
                    )
                })
                pagination(response.meta)
            }
        })
    }

    $(document).on('click', '.action-button', function (event) {
        event.preventDefault();
        const driverId = $(this).data('id');
        const actionUrl = $('#calculationTable').data('route-action');
        $.ajax({
            type: 'GET',
            url: actionUrl,
            data: { driver_id: driverId },
            dataType: 'json',
            success: function (response) {
                const calculation = response
                const row = $calculationTable.find(`#${driverId}`);
                row.html(calculation.total_minutes_with_passenger);
            },
        });
    });

    function pagination(data){
        if (!data.current_page) {
            $pagination.hide()
            return
        }

        var pathname = window.location.pathname;
        $pagination.twbsPagination('destroy')
        $pagination.twbsPagination({
            totalPages: data.last_page,
            startPage: data.current_page,
            visiblePages: 5,
            initiateStartPageClick: false,
            first: '<<',
            prev: '<',
            next: '>',
            last: '>>',
            onPageClick: function (event, page) {
                currentPage = page
                if (pathname === '/') {
                    getItems();
                } else if (pathname === '/calculation') {
                    getCalculation();
                }
            }
        });
    }

    $(document).on('keyup', 'input[type="search"]', function (event) {
        event.preventDefault();
        currentPage = 1;
        search = $(this).val();
        const tableId = $(this).attr('aria-controls');
        clearTimeout(timeout);

        if (tableId === 'table') {
            timeout = setTimeout(() => { getItems() }, 500);
        } else if (tableId === 'calculation_table') {
            timeout = setTimeout(() => { getCalculation() }, 500);
        }

        return false;
    });

    $(document).on('click', '.sorting', function (event) {
        event.preventDefault()
        const id = $(this).data('id')
        $(this).siblings('.sorting_asc').removeClass('sorting_asc').addClass('sorting')
        $(this).siblings('.sorting_desc').removeClass('sorting_desc').addClass('sorting')
        $(this).removeClass('sorting')
        $(this).addClass('sorting_asc')
        sort = id
        delimiter = 'asc'

        getItems();

        return false
    })

    $(document).on('click', '.sorting_asc', function (event) {
        event.preventDefault()
        const id = $(this).data('id')
        const tableId = $(this).data('table');
        $(this).removeClass('sorting_asc')
        $(this).addClass('sorting_desc')
        sort = id
        delimiter = 'desc'

        if (tableId === 'dashboard') {
            getItems();
        } else if (tableId === 'calculation') {
            getCalculation();
        }

        return false
    })

    $(document).on('click', '.sorting_desc', function (event) {
        event.preventDefault()
        const id = $(this).data('id')
        const tableId = $(this).data('table');
        $(this).removeClass('sorting_desc')
        $(this).addClass('sorting_asc')
        sort = id
        delimiter = 'asc'

        if (tableId === 'dashboard') {
            getItems();
        } else if (tableId === 'calculation') {
            getCalculation();
        }

        return false
    })
})