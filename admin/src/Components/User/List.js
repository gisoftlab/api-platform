import React from 'react';
import { List, Datagrid, TextField, EmailField,BooleanField, DateField, ShowButton, EditButton } from 'react-admin';

export const UserList = (props) => (
    <List {...props} title="Users" perPage={ 30 }>
        <Datagrid>
            <TextField source="id" label="ID"/>
            <EmailField source="email" label="Email" />
            <TextField source="username" label="Name"/>
            <BooleanField  source="enabled" label="Enabled"/>
            <DateField source="createdAt" label="Date"/>
            <ShowButton />
            <EditButton />
        </Datagrid>
    </List>
);
