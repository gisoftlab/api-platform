import React from 'react';
import { List, Datagrid, Filter,TextInput,SearchInput,QuickFilter,  TextField, EmailField,BooleanField, DateField, ShowButton, EditButton } from 'react-admin';
import { withStyles } from '@material-ui/core/styles';

export const ProductList = props => {
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

    const ProductFilter = props => (
        <Filter {...props}>
            <SearchInput source="title" alwaysOn />
            <TextInput
                source="title"
                defaultValue="Qui tempore rerum et voluptates"
            />
            {/*<QuickFilter*/}
            {/*    label="resources.posts.fields.commentable"*/}
            {/*    source="commentable"*/}
            {/*    defaultValue*/}
            {/*/>*/}
        </Filter>
    );

    return (
        <List
            {...props}
            filters={<ProductFilter />}
            sort={{ field: 'id', order: 'ASC' }}
            // exporter={exporter}
        >
            <Datagrid>
                {displayField('id')}
                <TextField source="title" label="title" sortable={true} />
                {displayField('promoted')}
                {displayField('price')}
                <ShowButton />
                <EditButton />
            </Datagrid>
        </List>

    );
};
