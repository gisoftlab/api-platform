// admin/src/Component/User/Show.js
import React from 'react';
import { Show, SimpleShowLayout, TextField, DateField, EmailField, EditButton } from 'react-admin';

export const AccountShow = (props) => (
    <Show { ...props }>
        <SimpleShowLayout>
            <TextField source="originId" label="ID"/>
            <EmailField source="username" label="username" />
            <TextField source="isActive" label="isActive"/>
            <EditButton />
        </SimpleShowLayout>
    </Show>
);
