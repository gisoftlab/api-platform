import React from 'react';
import { Edit, SimpleForm, DisabledInput, TextInput, email, ArrayInput, SimpleFormIterator, DateInput } from 'react-admin';

export const AccountEdit = (props) => (
    <Edit {...props}>
        <SimpleForm>
            <DisabledInput source="originId" label="ID"/>
            <TextInput source="username" label="username" validate={ email() } />
            <TextInput source="isActive" label="isActive"/>
            <ArrayInput source="roles" label="Roles">
                <SimpleFormIterator>
                    <TextInput />
                </SimpleFormIterator>
            </ArrayInput>
            <DateInput disabled source="createdAt" label="Date"/>
        </SimpleForm>
    </Edit>
);
