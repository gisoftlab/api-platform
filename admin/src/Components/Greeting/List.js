import React from 'react';
import { List, Datagrid, TextField, EmailField,BooleanField, DateField, ShowButton, EditButton } from 'react-admin';

export const GreetingList = props => {
    const getField = fieldName => {
        const {options: {resource: {fields}}} = props;

        return fields.find(resourceField => resourceField.name === fieldName) ||
            null;
    };

    const displayField = fieldName => {
        const {options: {api, fieldFactory, resource}} = props;

        const field = getField(fieldName);

        if (field === null) {
            return;
        }

        return fieldFactory(field, {api, resource});
    };

    return (
        <List {...props}>
            <Datagrid>
                {displayField('id')}
                {displayField('name')}
                <ShowButton />
                <EditButton />
            </Datagrid>
        </List>
    );
};
