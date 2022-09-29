@twillBlockTitle('Contact Form')
@twillBlockIcon('b-mail')
@formField('input', [
'name' => 'email',
'label' => 'Email',
'maxlength' => 100,
'required' => true,
'placeholder' => 'Email',
'note' => 'Inserisci l email'
])

@twillBlockValidationRules([
    'email' => 'required|email',
])

@formField('input', [
'name' => 'success_message',
'label' => 'Message',
'type' => 'textarea',
'translated' => true,
'placeholder' => 'Message',
])
