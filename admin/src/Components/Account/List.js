import React from 'react';
import { List, Datagrid, TextField, EmailField,BooleanField, DateField, ShowButton, EditButton } from 'react-admin';

export const AccountList = (props) => (
    <List {...props} title="Account" perPage={ 30 }>
        <Datagrid>
            <TextField source="id" label="ID"/>
            <TextField source="username" label="Name"/>
            <BooleanField  source="isActive" label="isActive"/>
            <ShowButton />
            <EditButton />
        </Datagrid>
    </List>
);
