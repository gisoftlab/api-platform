import React from 'react';
import { List, Datagrid } from 'react-admin';

// import PeopleIcon from '@material-ui/icons/People';
import { GreetingCreate } from './Create';
import { GreetingEdit } from './Edit';
import { GreetingList } from './List';
import { greetingsNameInput } from './inputs';
import { greetingsNameField } from './fields';

//const GreetingCreate = props => <p>Yay! I can do what I want!</p>;
//const GreetingEdit = props => <p>Yay! I can do what I want!</p>;


export default {
    name: 'greetings',
    list: GreetingList,
    create: GreetingCreate,
    edit: GreetingEdit,
    fields: [
        {
            name: 'name',
           // input: greetingsNameInput,
           // field: greetingsNameField,
        }
    ],
};
