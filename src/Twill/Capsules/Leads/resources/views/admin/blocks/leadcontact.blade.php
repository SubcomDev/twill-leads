@twillBlockTitle('Contact Form')
@twillBlockIcon('b-mail')
@formField('input', [
'name' => 'email',
'label' => 'Email Destinatario',
'type' => 'email',
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
'label' => 'Messaggio Thank you',
'type' => 'textarea',
'translated' => true,
'placeholder' => 'Messaggio Thank you',
])

@formField('input', [
'name' => 'labelButton',
'label' => 'Etichetta pulsante Invio',
'maxlength' => 100,
'required' => true,
'translated' => true,
'placeholder' => 'Label',
])

@formField('input', [
'name' => 'privacy_description',
'label' => 'Testo accettazione privacy',
'translated' => true,
'type' => 'textarea',
'editSource' => true,
'placeholder' => 'Privacy Description',
])
