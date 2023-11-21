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

    'accepted' => ':attribute باید تایید شود',
    'accepted_if' => 'زمانی که :other برابر :value است :attribute باید تایید شود',
    'active_url' => ':attribute یک آدرس سایت معتبر نیست',
    'after' => ':attribute باید تاریخی بعد از :date باشد',
    'after_or_equal' => ':attribute باید تاریخی مساوی یا بعد از :date باشد',
    'alpha' => ':attribute باید تنها شامل حروف باشد',
    'alpha_dash' => ':attribute باید تنها شامل حروف، اعداد، خط تیره و زیر خط باشد',
    'alpha_num' => ':attribute باید تنها شامل حروف و اعداد باشد',
    'array' => ':attribute باید آرایه باشد',
    'ascii' => ':attribute تنها میتواند شامل تک حرف، عدد یا نماد ها باشد. .',
    'before' => ':attribute باید تاریخی قبل از :date باشد',
    'before_or_equal' => ':attribute باید تاریخی مساوی یا قبل از :date باشد',
    'between' => [
        'array' => ':attribute باید بین :min و :max آیتم باشد',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد',
        'numeric' => ':attribute باید بین :min و :max باشد',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد',
    ],
    'boolean' => ':attribute تنها می تواند صحیح یا غلط باشد',
    'confirmed' => 'تایید مجدد :attribute صحیح نمی باشد',
    'current_password' => 'رمزعبور صحیح نمی باشد',
    'date' => ':attribute یک تاریخ صحیح نمی باشد',
    'date_equals' => ':attribute باید تاریخی مساوی با :date باشد',
    'date_format' => ':attribute با فرمت :format همخوانی ندارد',
    'decimal' => ':attribute باید :decimal رقم اعشار داشته باشد.',
    'declined' => ':attribute باید رد شود',
    'declined_if' => ':attribute زمانی که :other برابر :value است باید رد شود',
    'different' => ':attribute و :other باید متفاوت باشند',
    'digits' => ':attribute باید :digits عدد باشد',
    'digits_between' => ':attribute باید بین :min و :max عدد باشد',
    'dimensions' => 'ابعاد تصویر :attribute مجاز نمی باشد',
    'distinct' => ':attribute دارای افزونگی داده می باشد',
    'doesnt_end_with' => ':attribute نباید با این مقادیر به پایان برسد: :values.',
    'doesnt_start_with' => ':attribute نباید با این مقادیر شروع شود: :values.',
    'email' => ':attribute باید یک آدرس ایمیل صحیح باشد',
    'ends_with' => ':attribute باید با یکی از این مقادیر پایان یابد، :values',
    'enum' => ':attribute صحیح نمی باشد',
    'exists' => 'انتخاب شده :attribute صحیح نمی باشد',
    'file' => ':attribute باید یک فایل باشد',
    'filled' => ':attribute نمی تواند خالی باشد',
    'gt' => [
        'array' => ':attribute باید بیشتر از :value آیتم باشد',
        'file' => ':attribute باید بزرگتر از :value کیلوبایت باشد',
        'numeric' => ':attribute باید بزرگتر از :value باشد',
        'string' => ':attribute باید بزرگتر از :value کاراکتر باشد',
    ],
    'gte' => [
        'array' => ':attribute باید :value آیتم یا بیشتر داشته باشد',
        'file' => ':attribute باید بزرگتر یا مساوی :value کیلوبایت باشد',
        'numeric' => ':attribute باید بزرگتر یا مساوی :value باشد',
        'string' => ':attribute باید بزرگتر یا مساوی :value کاراکتر باشد',
    ],
    'image' => ':attribute باید از نوع تصویر باشد',
    'in' => 'انتخابی :attribute صحیح نمی باشد',
    'in_array' => ':attribute در :other وجود ندارد',
    'integer' => ':attribute باید از نوع عددی باشد',
    'ip' => ':attribute باید آی پی آدرس باشد',
    'ipv4' => ':attribute باید آی پی آدرس ورژن 4 باشد',
    'ipv6' => ':attribute باید آی پی آدرس ورژن 6 باشد',
    'json' => ':attribute باید از نوع رشته جیسون باشد',
    'lowercase' => ':attribute باید با حروف کوچک باشد.',
    'lt' => [
        'array' => ':attribute باید کمتر از :value آیتم داشته باشد',
        'file' => ':attribute باید کمتر از :value کیلوبایت باشد',
        'numeric' => ':attribute باید کمتر از :value باشد',
        'string' => ':attribute باید کمتر از :value کاراکتر باشد',
    ],
    'lte' => [
        'array' => ':attribute نباید کمتر از :value آیتم داشته باشد',
        'file' => ':attribute باید مساوی یا کمتر از :value کیلوبایت باشد',
        'numeric' => ':attribute باید مساوی یا کمتر از :value باشد',
        'string' => ':attribute باید مساوی یا کمتر از :value کاراکتر باشد',
    ],
    'mac_address' => ':attribute باید یک مک آدرس معتبر باشد',
    'max' => [
        'array' => ':attribute نباید بیشتر از :max آیتم داشته باشد',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد',
        'numeric' => ':attribute نباید بزرگتر از :max باشد',
        'string' => ':attribute نباید بزرگتر از :max کاراکتر باشد',
    ],
    'max_digits' => ':attribute نباید بیشتر از :max رقم باشد',
    'mimes' => ':attribute باید دارای یکی از این فرمت ها باشد: :values',
    'mimetypes' =>  ':attribute باید دارای یکی از این فرمت ها باشد: :values',
    'min' => [
        'array' => ':attribute باید حداقل :min آیتم داشته باشد',
        'file' => ':attribute باید حداقل :min کیلوبایت باشد',
        'numeric' => ':attribute باید حداقل :min باشد',
        'string' => ':attribute باید حداقل :min کاراکتر باشد',
    ],
    'min_digits' => ':attribute باید حداقل :min رقم باشد',
    'missing' => ':attribute نباید تعریف شود.',
    'missing_if' => ':attribute زمانی که مقدار :other برابر :value می باشد، نباید تعریف شود',
    'missing_unless' => ':attribute نباید تعریف شود مگر اینکه :other برابر :value باشد',
    'missing_with' => ':attribute زمانی که مقدار :values تعریف شده است دیگر نباید تعریف شود.',
    'missing_with_all' => ':attribute زمانی که :values مقدار دارد دیگر نباید تعریف شود.',
    'multiple_of' => ':attribute باید حاصل ضرب :value باشد',
    'not_in' => 'انتخابی :attribute صحیح نمی باشد',
    'not_regex' => 'فرمت :attribute صحیح نمی باشد',
    'numeric' => ':attribute باید از نوع عددی باشد',
    'password' => [
        'letters' => ':attribute باید حداقل شامل یک حرف باشد',
        'mixed' => ':attribute باید شامل حداقل یک حرف بزرگ و یک حرف کوچک باشد',
        'numbers' => ':attribute باید شامل حداقل یک عدد باشد',
        'symbols' => ':attribute باید شامل حداقل یک کارکتر خاص باشد',
        'uncompromised' => 'محتوای وارده شده در :attribute ایمن نمی باشد. لطفا :attribute را اصلاح فرمایید',
    ],
    'present' => ':attribute باید از نوع درصد باشد',
    'prohibited' => ':attribute مجاز نمی باشد',
    'prohibited_if' => ':attribute زمانی که :other برابر :value باشد مجاز نمی باشد',
    'prohibited_unless' => ':attribute مجاز نیست مگر :other برابر :values باشد',
    'prohibits' => ':attribute باعث ممنوعیت :other می باشد',
    'regex' => 'فرمت :attribute صحیح نمی باشد',
    'required' => 'تکمیل :attribute الزامی است',
    'required_array_keys' => ':attribute باید شامل مقادیر: :values باشد',
    'required_if' => 'تکمیل :attribute زمانی که :other دارای مقدار :value است الزامی می باشد',
    'required_if_accepted' => 'تکمیل :attribute زمانی که :other انتخاب شده الزامی است',
    'required_unless' => 'تکمیل :attribute الزامی می باشد مگر :other دارای مقدار :values باشد',
    'required_with' => 'تکمیل :attribute زمانی که مقدار :values درصد است الزامی است',
    'required_with_all' => 'تکمیل :attribute زمانی که مقادیر :values درصد است الزامی می باشد',
    'required_without' => 'تکمیل :attribute زمانی که مقدار :values درصد نیست الزامی است',
    'required_without_all' => 'تکمیل :attribute زمانی که هیچ کدام از مقادیر :values درصد نیست الزامی است',
    'same' => 'های :attribute و :other باید یکی باشند',
    'size' => [
        'array' => ':attribute باید شامل :size آیتم باشد',
        'file' => ':attribute باید :size کیلوبایت باشد',
        'numeric' => ':attribute باید :size باشد',
        'string' => ':attribute باید :size  کاراکتر باشد',
    ],
    'starts_with' => ':attribute باید با یکی از این مقادیر شروع شود، :values',
    'string' => ':attribute باید تنها شامل حروف باشد',
    'timezone' => ':attribute باید از نوع منطقه زمانی صحیح باشد',
    'unique' => 'این :attribute از قبل ثبت شده است',
    'uploaded' => 'بارگذاری :attribute شکست خورد',
    'uppercase' => ':attribute باید با حروف بزرگ باشد',
    'url' => 'فرمت :attribute اشتباه است',
    'ulid' => ':attribute باید یک ULID صحیح باشد.',
    'uuid' => ':attribute باید یک UUID صحیح باشد',
    'phone' => 'شماره همراه وارد شده صحیح نمی باشد.',

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

    'attributes' => [
        'name' => 'نام',
        'username' => 'نام کاربری',
        'email' => 'ایمیل',
        'first_name' => 'نام',
        'last_name' => 'نام خانوادگی',
        'password' => 'رمز عبور',
        'password_confirmation' => 'تاییدیه رمز عبور',
        'otp' => 'کد تایید',
        'phone' => 'شماره همراه',
    ],

];
