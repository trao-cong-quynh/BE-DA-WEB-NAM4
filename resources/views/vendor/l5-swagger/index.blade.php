<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.documentations.'.$documentation.'.api.title')}}</title>
    <!-- Sử dụng HTTPS cho tài nguyên Swagger UI -->
    <link rel="stylesheet" type="text/css" href="{{ secure_url(l5_swagger_asset($documentation, 'swagger-ui.css')) }}">
    <link rel="icon" type="image/png" href="{{ secure_url(l5_swagger_asset($documentation, 'favicon-32x32.png')) }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ secure_url(l5_swagger_asset($documentation, 'favicon-16x16.png')) }}" sizes="16x16"/>
    <style>
    html {
        box-sizing: border-box;
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
    }
    *,
    *:before,
    *:after {
        box-sizing: inherit;
    }

    body {
        margin: 0;
        background: #fafafa;
    }
    </style>
    @if(config('l5-swagger.defaults.ui.display.dark_mode'))
    <style>
        /* Dark mode styles */
        body#dark-mode,
        #dark-mode .scheme-container {
            background: #1b1b1b;
        }
        #dark-mode .scheme-container,
        #dark-mode .opblock .opblock-section-header{
            box-shadow: 0 1px 2px 0 rgba(255, 255, 255, 0.15);
        }
        #dark-mode .operation-filter-input,
        #dark-mode .dialog-ux .modal-ux,
        #dark-mode input[type=email],
        #dark-mode input[type=file],
        #dark-mode input[type=password],
        #dark-mode input[type=search],
        #dark-mode input[type=text],
        #dark-mode textarea {
            background: #343434;
            color: #e7e7e7;
        }
        /* More dark mode styles... */
    </style>
    @endif
</head>

<body @if(config('l5-swagger.defaults.ui.display.dark_mode')) id="dark-mode" @endif>
<div id="swagger-ui"></div>

<!-- Sử dụng HTTPS cho các tài nguyên JS Swagger UI -->
<script src="{{ secure_url(l5_swagger_asset($documentation, 'swagger-ui-bundle.js')) }}"></script>
<script src="{{ secure_url(l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js')) }}"></script>
<script>
    window.onload = function() {
        const ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            url: "{!! $urlToDocs !!}",
            operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
            configUrl: {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
            validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
            oauth2RedirectUrl: "{{ route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath) }}",

            requestInterceptor: function(request) {
                request.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                return request;
            },

            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],

            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],

            layout: "StandaloneLayout",
            docExpansion : "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
            deepLinking: true,
            filter: {!! config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' !!},
            persistAuthorization: "{!! config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' !!}",

        })

        window.ui = ui

        @if(in_array('oauth2', array_column(config('l5-swagger.defaults.securityDefinitions.securitySchemes'), 'type')))
        ui.initOAuth({
            usePkceWithAuthorizationCodeGrant: "{!! (bool)config('l5-swagger.defaults.ui.authorization.oauth2.use_pkce_with_authorization_code_grant') !!}"
        })
        @endif
    }
</script>
</body>
</html>
