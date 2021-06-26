<?php
return [
    'accepted'             => 'L\' :attribute doit être accepté.',
    'active_url'           => 'L\' :attribute n\'est pas une URL valide.',
    'after'                => 'L\' :attribute doit être une date après :date.',
    'after_or_equal'       => 'L\' :attribute doit être une date après ou égale à :date.',
    'alpha'                => 'L\' :attribute ne peut contenir que des lettres.',
    'alpha_dash'           => 'L\' :attribute ne peut contenir que des lettres, des chiffres, des tirets et des traits de soulignement.',
    'alpha_num'            => 'L\' :attribut ne peut contenir que des lettres et des chiffres.',
    'array'                => 'L\' :attribut doit être un tableau.',
    'before'               => 'L\' :attribute doit être une date avant :date.',
    'before_or_equal'      => 'L\' :attribute doit être une date antérieure ou égale à :date.',
    'between'              => [
        'numeric' => 'L\' :attribute doit être entre :min et :max.',
        'file'    => 'L\' :attribute doit être entre :min et :max kilooctets.',
        'string'  => 'L\' :attribute doit être entre :min et :max personnages.',
        'array'   => 'L\' :attribute doit avoir entre :min et :max articles.',
    ],
    'boolean'              => 'L\' :attribute doit être vrai ou faux.',
    'confirmed'            => 'L\' :attribute la confirmation ne correspond pas.',
    'date'                 => 'L\' :attribute la date n\'est pas valide.',
    'date_format'          => 'L\' :attribute ne correspond pas au format :format.',
    'different'            => 'L\' :attribute et :other doit être différent.',
    'digits'               => 'L\' :attribute doit être :digits chiffres.',
    'digits_between'       => 'L\' :attribute doit être entre :min de :max chiffres.',
    'dimensions'           => 'L\' :attribute a des dimensions d\'image non valides.',
    'distinct'             => 'L\' :attribute a une valeur en double.',
    'email'                => 'L\' :attribute doit être une adresse e-mail valide.',
    'exists'               => 'L\' choisi :attribute est invalide.',
    'file'                 => 'L\' :attribute doit être un fichier.',
    'filled'               => 'L\' :attribute doit avoir une valeur.',
    'gt'                   => [
        'numeric' => 'L\' :attribute doit être supérieur à :value.',
        'file'    => 'L\' :attribute doit être supérieur à :value kilooctets.',
        'string'  => 'L\' :attribute doit être supérieur à :value personnages.',
        'array'   => 'L\' :attribute doit avoir plus de :value articles.',
    ],
    'gte'                  => [
        'numeric' => 'L\' :attribute doit être supérieur ou égal :value.',
        'file'    => 'L\' :attribute doit être supérieur ou égal :value kilooctets.',
        'string'  => 'L\' :attribute doit être supérieur ou égal :value personnages.',
        'array'   => 'L\' :attribute doit avoir :value articles ou plus.',
    ],
    'image'                => 'L\' :attribute doit être une image.',
    'in'                   => 'L\' choisi :attribute est invalide.',
    'in_array'             => 'L\' :attribute n\'existe pas dans :other.',
    'integer'              => 'L\' :attribute doit être un entier.',
    'ip'                   => 'L\' :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'L\' :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'L\' :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'L\' :attribute doit être une chaîne JSON valide.',
    'lt'                   => [
        'numeric' => 'L\' :attribute doit être inférieur à :value.',
        'file'    => 'L\' :attribute doit être inférieur à :value kilooctets.',
        'string'  => 'L\' :attribute doit être inférieur à :value personnages.',
        'array'   => 'L\' :attribute doit être inférieur à :value articles.',
    ],
    'lte'                  => [
        'numeric' => 'L\' :attribute doit être inférieur ou égal :value.',
        'file'    => 'L\' :attribute doit être inférieur ou égal :value kilooctets.',
        'string'  => 'L\' :attribute doit être inférieur ou égal :value personnages.',
        'array'   => 'L\' :attribute ne doit pas avoir plus de :value articles.',
    ],
    'max'                  => [
        'numeric' => 'L\' :attribute ne peut pas être supérieur à :max.',
        'file'    => 'L\' :attribute ne peut pas être supérieur à :max kilobytes.',
        'string'  => 'L\' :attribute ne peut pas être supérieur à :max personnages.',
        'array'   => 'L\' :attribute peut ne pas avoir plus de :max articles.',
    ],
    'mimes'                => 'L\' :attribute doit être un fichier de type: :values.',
    'mimetypes'            => 'L\' :attribute doit être un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'L\' :attribute doit être au moins :min.',
        'file'    => 'L\' :attribute doit être au moins :min kilooctets.',
        'string'  => 'L\' :attribute doit être au moins :min personnages.',
        'array'   => 'L\' :attribute doit avoir au moins :min articles.',
    ],
    'not_in'               => 'L\' choisi :attribute est invalide.',
    'not_regex'            => 'L\' :attribute le format est invalide.',
    'numeric'              => 'L\' :attribute doit être un nombre.',
    'present'              => 'L\' :attribute presence obligatoire.',
    'regex'                => 'L\' :attribute le format est invalide.',
    'required'             => 'L\' :attribute est requis.',
    'required_if'          => 'L\' :attribute est requis lorsque :other est :value.',
    'required_unless'      => 'L\' :attribute est obligatoire sauf :other est dans :values.',
    'required_with'        => 'L\' :attribute est requis lorsque :values est présent.',
    'required_with_all'    => 'L\' :attribute est requis lorsque :values est présent.',
    'required_without'     => 'L\' :attribute est requis lorsque :values n\'est pas présent.',
    'required_without_all' => 'L\' :attribute est requis quand aucun des :values sont présents.',
    'same'                 => 'L\' :attribute et :other doit correspondre.',
    'size'                 => [
        'numeric' => 'L\' :attribute doit être :size.',
        'file'    => 'L\' :attribute doit être :size kilooctets.',
        'string'  => 'L\' :attribute doit être :size personnages.',
        'array'   => 'L\' :attribute doit contenir :size articles.',
    ],
    'string'               => 'L\' :attribute doit être une chaîne.',
    'timezone'             => 'L\' :attribute doit être une zone valide.',
    'unique'               => 'L\' :attribute a déjà été pris.',
    'uploaded'             => 'L\' :attribute Échec du téléchargement.',
    'url'                  => 'L\' :attribute le format est invalide.',

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
            'required' => 'L\' e-mail est obligatoire',
        ],
        'from_email_part2' => [
            'required' => 'L\' e-mail est obligatoire',
        ],
        'unique_list' => [
            'name' => 'L\' :attribute existe déjà dans ce groupe.',
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
        'list_id' => 'liste',
        'list_ids' => 'liste',
        'broadcast_ids' => 'diffuser',
        'role_id' => 'rôle',
        'group_id' => 'groupe',
        'campaign_id' => 'campagne',
        'sending_server_id' => 'serveur d\'envoi',
        'sending_server_ids' => 'serveur d\'envoi',
        'bounce_id' => 'email de rebond',
    ],
];
