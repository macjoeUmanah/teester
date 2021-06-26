<?php
return [
    'accepted'             => 'Das :attribute muss akzeptiert werden.',
    'active_url'           => 'Das :attribute ist keine gültige URL.',
    'after'                => 'Das :attribute muss ein Datum danach sein :date.',
    'after_or_equal'       => 'Das :attribute muss ein Datum nach oder gleich sein :date.',
    'alpha'                => 'Das :attribute Darf nur Buchstaben enthalten.',
    'alpha_dash'           => 'Das :attribute Darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num'            => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'                => 'Das :attribute muss ein Array sein.',
    'before'               => 'Das :attribute muss ein datum vorher sein:date.',
    'before_or_equal'      => 'Das :attribute muss ein Datum vor oder gleich sein :date.',
    'between'              => [
        'numeric' => 'Das :attribute muss dazwischen liegen :min und :max.',
        'file'    => 'Das :attribute muss dazwischen liegen :min und :max kilobyte.',
        'string'  => 'Das :attribute muss dazwischen liegen :min und :max zeichen.',
        'array'   => 'Das :attribute muss dazwischen haben :min und :max artikel.',
    ],
    'boolean'              => 'Das :attribute muss wahr oder falsch sein.',
    'confirmed'            => 'Das :attribute Bestätigung stimmt nicht überein.',
    'date'                 => 'Das :attribute ist kein gültiges Datum.',
    'date_format'          => 'Das :attribute stimmt nicht mit dem Format überein :format.',
    'different'            => 'Das :attribute und :other muss anders sein.',
    'digits'               => 'Das :attribute muss sein :digits ziffern.',
    'digits_between'       => 'Das :attribute muss dazwischen liegen :min und :max ziffern.',
    'dimensions'           => 'Das :attribute hat ungültige Bildabmessungen.',
    'distinct'             => 'Das :attribute hat einen doppelten Wert.',
    'email'                => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'exists'               => 'Das ausgewählt :attribute ist ungültig.',
    'file'                 => 'Das :attribute muss eine Datei sein.',
    'filled'               => 'Das :attribute muss einen Wert haben.',
    'gt'                   => [
        'numeric' => 'Das :attribute muss größer sein als :value.',
        'file'    => 'Das :attribute muss größer sein als :value kilobyte.',
        'string'  => 'Das :attribute muss größer sein als :value zeichen.',
        'array'   => 'Das :attribute muss mehr haben als :value artikel.',
    ],
    'gte'                  => [
        'numeric' => 'Das :attribute muss größer oder gleich sein :value.',
        'file'    => 'Das :attribute muss größer oder gleich sein :value kilobyte.',
        'string'  => 'Das :attribute muss größer oder gleich sein :value zeichen.',
        'array'   => 'Das :attribute haben müssen :value artikel oder mehr.',
    ],
    'image'                => 'Das :attribute muss ein Bild sein.',
    'in'                   => 'Das ausgewählt :attribute ist ungültig.',
    'in_array'             => 'Das :attribute existiert nicht in :other.',
    'integer'              => 'Das :attribute muss eine ganze Zahl sein.',
    'ip'                   => 'Das :attribute muss eine gültige IP-Adresse sein.',
    'ipv4'                 => 'Das :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6'                 => 'Das :attribute muss eine gültige IPv6-Adresse sein.',
    'json'                 => 'Das :attribute muss eine gültige JSON-Zeichenfolge sein.',
    'lt'                   => [
        'numeric' => 'Das :attribute muss kleiner sein als :value.',
        'file'    => 'Das :attribute muss kleiner sein als :value kilobyte.',
        'string'  => 'Das :attribute muss kleiner sein als :value zeichen.',
        'array'   => 'Das :attribute muss weniger haben als :value artikel.',
    ],
    'lte'                  => [
        'numeric' => 'Das :attribute muss kleiner oder gleich sein :value.',
        'file'    => 'Das :attribute muss kleiner oder gleich sein :value kilobyte.',
        'string'  => 'Das :attribute muss kleiner oder gleich sein :value zeichen.',
        'array'   => 'Das :attribute darf nicht mehr haben als :value artikel.',
    ],
    'max'                  => [
        'numeric' => 'Das :attribute darf nicht größer sein als :max.',
        'file'    => 'Das :attribute darf nicht größer sein als :max kilobytes.',
        'string'  => 'Das :attribute darf nicht größer sein als :max zeichen.',
        'array'   => 'Das :attribute darf nicht mehr als :max artikel.',
    ],
    'mimes'                => 'Das :attribute muss eine Datei von sein type: :values.',
    'mimetypes'            => 'Das :attribute muss eine Datei von sein type: :values.',
    'min'                  => [
        'numeric' => 'Das :attribute muss mindestens :min.',
        'file'    => 'Das :attribute muss mindestens :min kilobytes.',
        'string'  => 'Das :attribute muss mindestens :min zeichen.',
        'array'   => 'Das :attribute muss mindestens haben :min artikel.',
    ],
    'not_in'               => 'Das ausgewählt :attribute ist ungültig.',
    'not_regex'            => 'Das :attribute format ist ungültig.',
    'numeric'              => 'Das :attribute muss eine nummer sein.',
    'present'              => 'Das :attribute muss anwesend sein.',
    'regex'                => 'Das :attribute format ist ungültig.',
    'required'             => 'Das :attribute wird benötigt.',
    'required_if'          => 'Das :attribute wird benötigt wenn :other ist :value.',
    'required_unless'      => 'Das :attribute ist erforderlich, es sei denn :other ist in :values.',
    'required_with'        => 'Das :attribute wird benötigt wenn :values ist anwesend.',
    'required_with_all'    => 'Das :attribute wird benötigt wenn :values ist anwesend.',
    'required_without'     => 'Das :attribute wird benötigt wenn :values ist nicht hier.',
    'required_without_all' => 'Das :attribute ist erforderlich, wenn keiner von :values sind anwesend.',
    'same'                 => 'Das :attribute und :other muss passen.',
    'size'                 => [
        'numeric' => 'Das :attribute muss sein :size.',
        'file'    => 'Das :attribute muss sein :size kilobyte.',
        'string'  => 'Das :attribute muss sein :size zeichen.',
        'array'   => 'Das :attribute muss enthalten :size artikel.',
    ],
    'string'               => 'Das :attribute muss eine zeichenfolge sein.',
    'timezone'             => 'Das :attribute muss eine gültige zone sein.',
    'unique'               => 'Das :attribute wurde bereits vergeben.',
    'uploaded'             => 'Das :attribute upload fehlgeschlagen.',
    'url'                  => 'Das :attribute format ist ungültig.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using Das
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'from_email_part1' => [
            'required' => 'Die von E-Mail ist erforderlich',
        ],
        'from_email_part2' => [
            'required' => 'Die von E-Mail ist erforderlich',
        ],
        'unique_list' => [
            'name' => 'Das :attribute existiert bereits in dieser Gruppe.',
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
        'broadcast_ids' => 'Übertragung',
        'role_id' => 'rolle',
        'group_id' => 'gruppe',
        'campaign_id' => 'kampagne',
        'sending_server_id' => 'sendender server',
        'sending_server_ids' => 'sendender server',
        'bounce_id' => 'bounce-E-Mail',
    ],
];
