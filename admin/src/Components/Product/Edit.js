import React from 'react';
import { Edit, SimpleForm, DisabledInput, TextInput, email,required, ArrayInput, SimpleFormIterator, DateInput } from 'react-admin';

export const ProductEdit = (props) => (
    <Edit {...props}>
        <SimpleForm>
            <DisabledInput source="id" label="ID"/>
            <TextInput source="title" label="title" validate={ required() } />
            <DateInput disabled source="createdAt" label="Date"/>
        </SimpleForm>
    </Edit>
);
