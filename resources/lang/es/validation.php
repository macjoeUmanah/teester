<?php
return [
    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una URL válida.',
    'after'                => 'El :attribute debe ser una fecha posterior :date.',
    'after_or_equal'       => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El :attribute solo puede contener letras.',
    'alpha_dash'           => 'El :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El :attribute solo puede contener letras y números.',
    'array'                => 'El :attribute debe ser una matriz.',
    'before'               => 'El :attribute debe ser una fecha antes :date.',
    'before_or_equal'      => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file'    => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string'  => 'El :attribute debe estar entre :min y :max caracteres.',
        'array'   => 'El :attribute debe tener entre :min y :max artículos.',
    ],
    'boolean'              => 'El :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El :attribute la confirmación no coincide.',
    'date'                 => 'El :attribute no es una fecha válida.',
    'date_format'          => 'El :attribute no coincide con el formato :format.',
    'different'            => 'El :attribute y :other debe ser diferente',
    'digits'               => 'El :attribute debe ser :digits dígitos.',
    'digits_between'       => 'El :attribute debe estar entre :min y :max dígitos.',
    'dimensions'           => 'El :attribute tiene dimensiones de imagen no válidas.',
    'distinct'             => 'El :attribute tiene un valor duplicado.',
    'email'                => 'El :attribute debe ser una dirección de correo electrónico válida.',
    'exists'               => 'El seleccionado :attribute Es invalido.',
    'file'                 => 'El :attribute debe ser un archivo.',
    'filled'               => 'El :attribute debe ser un archivo.',
    'gt'                   => [
        'numeric' => 'El :attribute debe ser mayor que :value.',
        'file'    => 'El :attribute debe ser mayor que :value kilobytes.',
        'string'  => 'El :attribute debe ser mayor que :value caracteres.',
        'array'   => 'El :attribute debe tener más de :value artículos.',
    ],
    'gte'                  => [
        'numeric' => 'El :attribute debe ser mayor o igual :value.',
        'file'    => 'El :attribute debe ser mayor o igual :value kilobytes.',
        'string'  => 'El :attribute debe ser mayor o igual :value caracteres.',
        'array'   => 'El :attribute debe :value artículos de valor o más.',
    ],
    'image'                => 'El :attribute debe ser una imagen.',
    'in'                   => 'El seleccionado:attribute Es invalido.',
    'in_array'             => 'El :attribute no existe en :other.',
    'integer'              => 'El :attribute debe ser un entero.',
    'ip'                   => 'El :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El :attribute debe ser una cadena JSON válida.',
    'lt'                   => [
        'numeric' => 'El :attribute debe ser menor que :value.',
        'file'    => 'El :attribute debe ser menor que :value kilobytes.',
        'string'  => 'El :attribute debe ser menor que :value caracteres.',
        'array'   => 'El :attribute debe tener menos de :value artículos.',
    ],
    'lte'                  => [
        'numeric' => 'El :attribute must be less than or equal :value.',
        'file'    => 'El :attribute must be less than or equal :value kilobytes.',
        'string'  => 'El :attribute must be less than or equal :value caracteres.',
        'array'   => 'El :attribute must not have more than :value artículos.',
    ],
    'max'                  => [
        'numeric' => 'El :attribute no puede ser mayor que :max.',
        'file'    => 'El :attribute no puede ser mayor que :max kilobytes',
        'string'  => 'El :attribute no puede ser mayor que :max caracteres.',
        'array'   => 'El :attribute puede no tener más de :max artículos.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo de type: :values.',
    'mimetypes'            => 'El :attribute debe ser un archivo de type: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe ser por lo menos :min.',
        'file'    => 'El :attribute debe ser por lo menos :min kilobytes.',
        'string'  => 'El :attribute debe ser por lo menos :min caracteres.',
        'array'   => 'El :attribute debe ser por lo menos :min artículos.',
    ],
    'not_in'               => 'El seleccionado :attribute es invalido.',
    'not_regex'            => 'El :attribute el formato no es válido.',
    'numeric'              => 'El :attribute Tiene que ser un número.',
    'present'              => 'El :attribute debe estar presente.',
    'regex'                => 'El :attribute el formato no es válido.',
    'required'             => 'El :attribute es requerido.',
    'required_if'          => 'El :attribute se requiere cuando :other es :value.',
    'required_unless'      => 'El :attribute se requiere a menos que :other es en :values.',
    'required_with'        => 'El :attribute se requiere cuando :values está presente.',
    'required_with_all'    => 'El :attribute se requiere cuando :values está presente.',
    'required_without'     => 'El :attribute se requiere cuando :values no es presente.',
    'required_without_all' => 'El :attribute se requiere cuando ninguno de :values están presentes.',
    'same'                 => 'El :attribute y :other debe coincidir con.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attribute debe ser :size kilobytes.',
        'string'  => 'El :attribute debe ser :size caracteres.',
        'array'   => 'El :attribute debe contener :size artículos.',
    ],
    'string'               => 'El :attribute debe ser una cadena',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => 'El :attribute ya se ha tomado.',
    'uploaded'             => 'El :attribute no se pudo cargar.',
    'url'                  => 'El :attribute el formato no es válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'from_email_part1' => [
            'required' => 'Se requiere el correo electrónico de',
        ],
        'from_email_part2' => [
            'required' => 'Se requiere el correo electrónico de',
        ],
        'unique_list' => [
            'name' => 'El :attribute already exist within this group.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'email' => 'email',
        'list_id' => 'lista',
        'list_ids' => 'lista',
        'broadcast_ids' => 'campaña',
        'role_id' => 'papel',
        'group_id' => 'grupo',
        'campaign_id' => 'campaña',
        'sending_server_id' => 'servidor de envío',
        'sending_server_ids' => 'servidor de envío',
        'bounce_id' => 'correo electrónico de rebote',
    ],
];
