import React from 'react';
import { Create, SimpleForm, TextInput, email, required, ArrayInput, SimpleFormIterator } from 'react-admin';

export const AccountCreate = (props) => (
    <Create { ...props }>
        <SimpleForm>
            <TextInput source="username" label="username" validate={ required() } />
            <TextInput source="isActive" label="isActive"/>
            <ArrayInput source="roles" label="Roles">
                <SimpleFormIterator>
                    <TextInput />
                </SimpleFormIterator>
            </ArrayInput>
        </SimpleForm>
    </Create>
);
