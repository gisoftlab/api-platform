// admin/src/Component/User/Show.js
import React from 'react';
import { Show, SimpleShowLayout, TextField, DateField, EmailField, EditButton } from 'react-admin';

export const ProductShow = (props) => (
    <Show { ...props }>
        <SimpleShowLayout>
            <TextField source="id" label="ID"/>
            <EmailField source="title" label="title" />
            <EditButton />
        </SimpleShowLayout>
    </Show>
);
