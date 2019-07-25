import React from 'react';
import { Create, SimpleForm, TextInput, email, required, ArrayInput, SimpleFormIterator } from 'react-admin';

export const ProductCreate = (props) => (
    <Create { ...props }>
        <SimpleForm>
            <TextInput source="title" label="title" validate={ required() } />
        </SimpleForm>
    </Create>
);
