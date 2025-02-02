<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Show email_template
                            </h2>
                            <div class="flex justify-end mt-5">
                                <a class="px-2 py-1 rounded-md bg-sky-500 text-sky-100 hover:bg-sky-600" href="{{ route('email_template.index') }}" title="Back">< Back</a>
                            </div>
                        </header>
                        </br>

                        <table class="shadow-lg bg-white">
                            <tr>
                                <td class="border px-8 py-4 font-bold">ID</td>
                                <td class="border px-8 py-4">{{ $email_template->id }}</td>
                            </tr>
                            <tr><td class="border px-8 py-4 font-bold"> Tplname </td><td class="border px-8 py-4"> {{ $email_template->tplname }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Language Id </td><td class="border px-8 py-4"> {{ $email_template->language_id }} </td></tr><tr><td class="border px-8 py-4 font-bold"> Param </td><td class="border px-8 py-4"> {{ $email_template->param }} </td></tr>
                        </table>

                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
