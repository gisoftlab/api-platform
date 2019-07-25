import React from 'react';
import { List, Datagrid, TextField, EmailField,BooleanField, DateField, ShowButton, EditButton } from 'react-admin';

export const ProductList = (props) => (
    <List {...props} title="Product" perPage={ 30 }>
        <Datagrid>
            <TextField source="id" label="ID"/>
            <TextField source="title" label="title"/>
            <ShowButton />
            <EditButton />
        </Datagrid>
    </List>
);
