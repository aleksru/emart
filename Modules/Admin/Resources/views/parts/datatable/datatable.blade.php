
<div class="table-responsive">
    <table id="{{ $id }}" class="table table-striped table-datatable" style="width: 100%;">
        <thead>
            <tr>
                @foreach ($columns as $name => $column)
                    <th class="th-{{ $name }}">{{ $column['name'] }}</th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>

@push('script')
    <script type="text/javascript">
        $(function () {
            /**
             * Базовые настройки таблицы.
             */ 
            const table = $('#{{ $id }}').DataTable({
                language: {
                    url: '/assets/vendors/DataTables/lang/ru.json',
                },
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                searchDelay: 500,
                ajax: {
                    url: '{{ $route }}',
                    type: 'get',
                },
                columns: [
                    @foreach ($columns as $name => $column)
                    { 
                        data: '{{ $name }}', 
                        name: '{{ $name }}', 
                        width: '{{ $column['width'] ?? '' }}',
                    },
                    @endforeach
                ],
                columnDefs: [
                    {
                        orderable: false,
                        targets: [
                            @foreach ($columns as $name => $column)
                                @if (isset($column['orderable']) && $column['orderable'] === false)
                                    'th-{{ $name }}',
                                @endif
                            @endforeach
                        ]
                    },
                    {
                        searchable: false,
                        targets: [
                            @foreach ($columns as $name => $column)
                                @if (empty($column['searchable']))
                                'th-{{ $name }}',
                                @endif
                            @endforeach
                        ]
                    }
                ]
            });

            /**
             * Дебаунс на поиск
             */
            setTimeout(function () {
                let input = $('#{{ $id }}_filter input[type="search"]');
                input.off().on('keyup cut paste', _.debounce(() => table.search(input.val()).draw(), table.settings()[0].searchDelay));
            }, 500);

            /**
             * Обработчик на тогглы
             */
            $('#{{ $id }}').on('click', '.btn-toggle', function (event) {
                event.preventDefault();
                let route = $(this).data('route');
                let id    = $(this).data('id');

                let toastID = 'toast-toggle-' + id;

                if ($('#' + toastID).length > 0)
                    return false;

                toast.loading('Подождите, идет обработка', {
                    id: toastID,
                });

                axios.post(route)
                    .then((response) => {
                        table.ajax.reload(() => {
                            toast.hide(toastID);
                            toast.success(response.data.message);
                        }, false);
                    })
                    .catch((error) => {
                        toast.hide(toastID);
                        let errorMessage = 'Ошибка сервера! Пожалуйста, свяжитесь с администратором.';

                        if (error.response.data.message) {
                            errorMessage = error.response.data.message;
                        }
                        toast.error(errorMessage);
                    });

            });

            /**
             * Обработчик на кнопку удаления
             */
            $('#{{ $id }}').on('click', '.btn-delete', function (event) {
                event.preventDefault();
                let id      = $(this).data('id');
                let name    = $(this).data('name');
                let route   = $(this).data('route');
                
                let toastID = 'toast-delete-' + id;

                if ($('#' + toastID).length > 0)
                    return false;
                
                toast.confirm('Вы действительно хотите удалить элемент "' + name + '"?', function () {
                    let loading = toast.loading('Идет удаление "' + name + '"');
                    axios.delete(route)
                        .then((response) => {
                            table.ajax.reload(() => {
                                toast.hide(loading);
                                toast.success(response.data.message);
                            }, false);
                        })
                        .catch((error) => {
                            toast.hide(loading);
                            toast.error('Ошибка сервера! Пожалуйста, свяжитесь с администратором.');
                        })
                }, null, { id: toastID });
            })
        })
    </script>
@endpush