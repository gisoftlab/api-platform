import React from 'react';
import {
    List,
    Responsive,
    SimpleList,
    Show,
    Edit,
    SimpleForm,
    SimpleShowLayout,
    RichTextField,
    Datagrid,
    DatagridBody,
    Filter,
    TextInput,
    SearchInput,
    QuickFilter,
    TextField,
    EmailField,
    BooleanField,
    DateField,
    downloadCSV,
    ShowButton,
    EditButton,
    Pagination,
} from 'react-admin';
import { withStyles } from '@material-ui/core/styles';
import TableCell from '@material-ui/core/TableCell';
import TableRow from '@material-ui/core/TableRow';
import Checkbox from '@material-ui/core/Checkbox';
//import RichTextInput from 'ra-input-rich-text';
import { unparse as convertToCSV } from 'papaparse/papaparse.min';

// import Pagination from './Pagination';
import Button from '@material-ui/core/Button';
import ChevronLeft from '@material-ui/icons/ChevronLeft';
import ChevronRight from '@material-ui/icons/ChevronRight';
import Toolbar from '@material-ui/core/Toolbar';

import MyUrlField from './MyUrlField';

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


    const exporter = (records, fetchRelatedRecords) => {
        fetchRelatedRecords(records, 'id', 'product').then(posts => {
            const data = records.map(record => ({
                ...record,
                product_title: posts[record.id].title,
            }));
            const csv = convertToCSV({
                data,
                fields: ['id', 'title', 'short', 'description'],
            });
            downloadCSV(csv, 'comments');
        });
    };

    const ProductPanel = ({ id, record, resource }) => (
        <div dangerouslySetInnerHTML={{ __html: record.body }} />
    );

    const ProductShow = props => (
        <Show
            {...props}
            /* disable the app title change when shown */
            title=" "
        >
            <SimpleShowLayout>
                <RichTextField source="description" />
            </SimpleShowLayout>
        </Show>
    );

    // const ProductEdit = props => (
    //     <Edit
    //         {...props}
    //         /* disable the app title change when shown */
    //         title=" "
    //     >
    //         <SimpleForm
    //             /* The form must have a name dependent on the record, because by default all forms have the same name */
    //             form={`product_edit_${props.id}`}
    //         >
    //             <TextInput
    //                 source="description"
    //                 defaultValue=""
    //             />
    //         </SimpleForm>
    //     </Edit>
    // );


    const PostPagination = props => <Pagination rowsPerPageOptions={[10, 25, 50, 100]} {...props} />

    const postRowStyle = (record, index) => ({
        backgroundColor: record.nb_views >= 500 ? '#efe' : 'white',
    });

    return (
        <List
            {...props}
            filters={<ProductFilter />}
            pagination={<PostPagination />}
            sort={{ field: 'id', order: 'ASC' }}
            exporter={exporter}
            title="List of products"
        >
            <Responsive
                small={
                    <SimpleList
                        primaryText={record => record.title}
                        secondaryText={record => `${record.views} views`}
                        tertiaryText={record => new Date(record.published_at).toLocaleDateString()}
                    />
                }
                medium={
                    <Datagrid rowClick="edit" rowStyle={postRowStyle} expand={<ProductShow />}>
                        {displayField('id')}
                        <TextField source="title" label="title" sortable={true} />
                        <MyUrlField source="title" />
                        {displayField('promoted')}
                        {displayField('price')}
                        <ShowButton />
                        <EditButton />
                    </Datagrid>
                }
            />


        </List>

    );
};
