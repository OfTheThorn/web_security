<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form method="post" action="{{route("gins.store")}}">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Gin name') }}"/>
                        <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full"/>
                    </div>
                    <br/>
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}"/>
                        <x-jet-input id="description" name="description" type="text" class="mt-1 block w-full"/>
                    </div>
                    <br/>
                    <input type="submit" value="Create new gin"/>
                </form>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Delete</th>
                        <th>New name</th>
                        <th>New description</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <div class="text-center">
            <a href="https://www.ofthethorn.be/privacy">Privacy policy</a>
        </div>
    </footer>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        window.onload = function () {
            let ginList = [];
            axios.get('http://localhost:8000/api/gins')
                .then(response => {
                    ginList = response.data;

                    let rows = ginList.data.forEach(function (value) {
                        let link = "http://localhost:8000/api/gins/" + value.id;
                        let button = '<button class="btnDelete">' + "Delete" + '</button>';
                        let btnEdit = '<button class="btnEdit">' + "Edit" + '</button>';

                        let newName = '<input class="newName" name="name" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"/>';
                        let newDescription = '<input class="newDescription" name="description" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full"/></div>';

                        $('table tr:last').after('<tr id=' + value.id + '><td>' + value.name + '</td><td>' + value.description + '</td><td>' + button + '</td><td>' + newName + '</td><td>' + newDescription + '</td><td>' + btnEdit + '</td></tr>');

                    });
                })
                .catch(error => console.error(error));

            $("table").on('click', '.btnDelete', function () {
                let id = $(this).closest('tr').attr('id');
                let url = "http://localhost:8000/api/gins/" + id;
                axios.delete(url, {
                    headers: {}
                }).then(function(){
                    window.location.reload()
                });
            });

            $("table").on('click', '.btnEdit', function () {
                let id = $(this).closest('tr').attr('id');
                let name = $(this).closest('tr').find('td .newName').val();
                let description = $(this).closest('tr').find('td .newDescription').val();
                let url = "http://localhost:8000/api/gins/" + id;
                let data = JSON.stringify({"name": name, "description": description});

                let config = {
                    method: 'put',
                    url: url,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    data : data
                };
                axios(config).then(function (response) {
                    window.location.reload()
                });
            });

        };
    </script>
</x-app-layout>
