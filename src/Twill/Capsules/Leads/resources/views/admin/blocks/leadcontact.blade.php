@twillBlockTitle('Contact Form')
@twillBlockIcon('b-mail')
@formField('input', [
'name' => 'email',
'label' => 'Email',
'maxlength' => 100,
'required' => true,
'placeholder' => 'Email',
])

@formField('input', [
'name' => 'message',
'label' => 'Message',
'maxlength' => 200,
'type' => 'textarea',
'placeholder' => 'Message',
])

