@twillBlockTitle('Leads')
@twillBlockIcon('text')

@formField('input', [
'name' => 'title',
'label' => 'Title',
'maxlength' => 100,
'required' => true,
'translated' => true,
'placeholder' => 'Title',
])

@formField('input', [
'name' => 'description',
'label' => 'Description',
'type' => 'textarea',
'translated' => true,
'placeholder' => 'Description',
])

@formField('input', [
'name' => 'privacy_description',
'label' => 'Privacy Description',
'translated' => true,
'placeholder' => 'Privacy Description',
])
