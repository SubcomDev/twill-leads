@extends('admin.layouts.free')






@push('extra_css')
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        .v-application div,
        td,
        th {
            vertical-align: middle !important;
        }

        @media (min-width: 960px) {
            .container {
                max-width: 1440px;
            }
        }

        .header {
            padding-bottom: 38px;
        }

        .container {
            width: 100%;
            padding: 0px 12px 12px 0px;
            margin-right: auto;
            margin-left: auto;
        }
    </style>
@endpush

@section('content')
    <app-leads></app-leads>
@endsection


@push('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js" crossorigin></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ twillAsset('/leads/index.js') }}" type="module"></script>
@endpush
