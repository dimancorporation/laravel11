<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute должно быть принято.',
    'accepted_if' => 'Поле :attribute должно быть принято, когда :other равно :value.',
    'active_url' => 'Поле :attribute должно содержать корректный URL.',
    'after' => 'Поле :attribute должно содержать дату после :date.',
    'after_or_equal' => 'Поле :attribute должно содержать дату после или равную :date.',
    'alpha' => 'Поле :attribute может содержать только буквы.',
    'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
    'ascii' => 'Поле :attribute может содержать только однобайтовую буквенно-цифровую информацию и символы.',
    'before' => 'Поле :attribute должно содержать дату до :date.',
    'before_or_equal' => 'Поле :attribute должно содержать дату до или равную :date.',
    'between' => [
        'array' => 'В поле :attribute должно быть от :min до :max элементов.',
        'file' => 'Файл в поле :attribute должен иметь размер от :min до :max килобайт.',
        'numeric' => 'Числовое значение в поле :attribute должно находиться между :min и :max.',
        'string' => 'Строка в поле :attribute должна содержать от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'can' => 'Поле :attribute содержит неавторизованное значение.',
    'confirmed' => 'Подтверждение поля :attribute не совпадает.',
    'contains' => 'Поле :attribute отсутствует требуемое значение.',
    'current_password' => 'Неверный пароль.',
    'date' => 'Поле :attribute должно содержать корректную дату.',
    'date_equals' => 'Поле :attribute должно содержать дату, равную :date.',
    'date_format' => 'Поле :attribute должно соответствовать формату :format.',
    'decimal' => 'Поле :attribute должно содержать :decimal десятичных знаков.',
    'declined' => 'Поле :attribute должно быть отклонено.',
    'declined_if' => 'Поле :attribute должно быть отклонено, если :other равно :value.',
    'different' => 'Поля :attribute и :other должны различаться.',
    'digits' => 'Поле :attribute должно содержать :digits цифр.',
    'digits_between' => 'Поле :attribute должно содержать от :min до :max цифр.',
    'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute содержит повторяющееся значение.',
    'doesnt_end_with' => 'Поле :attribute не должно заканчиваться одним из следующих значений: :values.',
    'doesnt_start_with' => 'Поле :attribute не должно начинаться с одного из следующих значений: :values.',
    'email' => 'Поле :attribute должно содержать корректный адрес электронной почты.',
    'ends_with' => 'Поле :attribute должно оканчиваться одним из следующих значений:attribute :values.',
    'enum' => 'Выбранное значение :attribute является недействительным.',
    'exists' => 'Выбранное значение :attribute является недействительным.',
    'extensions' => 'Поле :attribute должно иметь одно из следующих расширений: :values.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'В поле :attribute должно быть больше чем :value элементов.',
        'file' => 'Файл в поле :attribute должен быть больше :value килобайт.',
        'numeric' => 'Число в поле :attribute должно быть больше :value.',
        'string' => 'Строка в поле :attribute должна быть длиннее :value символов.',
    ],
    'gte' => [
        'array' => 'В поле :attribute должно быть :value элементов или больше.',
        'file' => 'Файл в поле :attribute должен быть больше или равен :value килобайт.',
        'numeric' => 'Число в поле :attribute должно быть больше или равно :value.',
        'string' => 'Строка в поле :attribute должна быть длиной :value символов или больше.',
    ],
    'hex_color' => 'Поле :attribute должно содержать корректный шестнадцатеричный цвет.',
    'image' => 'Поле :attribute должно содержать изображение.',
    'in' => 'Выбранное значение :attribute является недопустимым.',
    'in_array' => 'Поле :attribute должно существовать в :other.',
    'integer' => 'Поле :attribute должно содержать целое число.',
    'ip' => 'Поле :attribute должно содержать корректный IP-адрес.',
    'ipv4' => 'Поле :attribute должно содержать корректный IPv4-адрес.',
    'ipv6' => 'Поле :attribute должно содержать корректный IPv6-адрес.',
    'json' => 'Поле :attribute должно содержать корректную строку в формате JSON.',
    'list' => 'Поле :attribute должно быть списком.',
    'lowercase' => 'Поле :attribute должно содержать строчные буквы.',
    'lt' => [
        'array' => 'В поле :attribute должно быть меньше чем :value элементов.',
        'file' => 'Файл в поле :attribute должен быть меньше :value килобайт.',
        'numeric' => 'Число в поле :attribute должно быть меньше :value.',
        'string' => 'Строка в поле :attribute должна быть короче :value символов.',
    ],
    'lte' => [
        'array' => 'В поле :attribute должно быть не больше :value элементов.',
        'file' => 'Файл в поле :attribute должен быть меньше или равен :value килобайт.',
        'numeric' => 'Число в поле :attribute должно быть меньше или равно :value.',
        'string' => 'Строка в поле :attribute должна быть длиной :value символов или меньше.',
    ],
    'mac_address' => 'Поле :attribute должно содержать корректный MAC-адрес.',
    'max' => [
        'array' => 'В поле :attribute должно быть не больше :max элементов.',
        'file' => 'Файл в поле :attribute не должен превышать :max килобайт.',
        'numeric' => 'Число в поле :attribute не должно превышать :max.',
        'string' => 'Строка в поле :attribute не должна превышать :max символов.',
    ],
    'max_digits' => 'Поле :attribute не должно содержать более :max цифр.',
    'mimes' => 'Поле :attribute должно содержать файл типа: :values.',
    'mimetypes' => 'Поле :attribute должно содержать файл типа: :values.',
    'min' => [
        'array' => 'В поле :attribute должно быть как минимум :min элементов.',
        'file' => 'Файл в поле :attribute должен быть размером не менее :min килобайт.',
        'numeric' => 'Число в поле :attribute должно быть не менее :min.',
        'string' => 'Строка в поле :attribute должна содержать не менее :min символов.',
    ],
    'min_digits' => 'Поле :attribute должно содержать не менее :min цифр.',
    'missing' => 'Поле :attribute должно отсутствовать.',
    'missing_if' => 'Поле :attribute должно отсутствовать, если :other равно :value.',
    'missing_unless' => 'Поле :attribute должно отсутствовать, если :other не равно :value.',
    'missing_with' => 'Поле :attribute должно отсутствовать, если присутствует :values.',
    'missing_with_all' => 'Поле :attribute должно отсутствовать, если присутствуют все :values.',
    'multiple_of' => 'Поле :attribute должно быть кратно :value.',
    'not_in' => 'Выбранное значение :attribute является недопустимым.',
    'not_regex' => 'Формат поля :attribute неверен.',
    'numeric' => 'Поле :attribute должно содержать число.',
    'password' => [
        'letters' => 'Поле :attribute должно содержать хотя бы одну букву.',
        'mixed' => 'Поле :attribute должно содержать хотя бы одну заглавную и одну строчную букву.',
        'numbers' => 'Поле :attribute должно содержать хотя бы одну цифру.',
        'symbols' => 'Поле :attribute должно содержать хотя бы один символ.',
        'uncompromised' => 'Предоставленное :attribute было обнаружено в утечке данных. Пожалуйста, выберите другое :attribute.',
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'present_if' => 'Поле :attribute должно присутствовать, если :other равно :value.',
    'present_unless' => 'Поле :attribute должно присутствовать, если :other не равно :value.',
    'present_with' => 'Поле :attribute должно присутствовать, если присутствует :values.',
    'present_with_all' => 'Поле :attribute должно присутствовать, если присутствуют все :values.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, если :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не находится среди :values.',
    'prohibits' => 'Поле :attribute запрещает присутствие :other.',
    'regex' => 'Формат поля :attribute недействителен.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute обязательно для заполнения, если :other равно :value.',
    'required_if_accepted' => 'Поле :attribute обязательно для заполнения, если :other принято.',
    'required_if_declined' => 'Поле :attribute обязательно для заполнения, если :other отклонено.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, если :other не находится среди :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, если присутствует :values.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, если присутствуют все :values.',
    'required_without' => 'Поле :attribute обязательно для заполнения, если :values отсутствует.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, если ни одно из :values не присутствует.',
    'same' => 'Поле :attribute должно совпадать с :other.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Размер поля :attribute должен быть :size килобайт.',
        'numeric' => 'Значение поля :attribute должно быть равно :size.',
        'string' => 'Длина строки в поле :attribute должна составлять :size символов.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться с одного из следующих значений: :values.',
    'string' => 'Поле :attribute должно содержать строку.',
    'timezone' => 'Поле :attribute должно содержать корректную временную зону.',
    'unique' => 'Такое значение :attribute уже занято.',
    'uploaded' => 'Не удалось загрузить файл в поле :attribute.',
    'uppercase' => 'Поле :attribute должно содержать прописные буквы.',
    'url' => 'Поле :attribute должно содержать корректный URL.',
    'ulid' => 'Поле :attribute должно содержать корректный идентификатор ULID.',
    'uuid' => 'Поле :attribute должно содержать корректный идентификатор UUID.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
