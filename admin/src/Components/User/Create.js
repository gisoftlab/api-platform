import React from 'react';
import { Create, SimpleForm, TextInput, email, required, ArrayInput, SimpleFormIterator } from 'react-admin';

export const UserCreate = (props) => (
    <Create { ...props }>
        <SimpleForm>
            <TextInput source="email" label="Email" validate={ email() } />
            <TextInput source="plainPassword" label="Password" validate={ required() } />
            <TextInput source="username" label="Username"/>
            <TextInput source="username" label="Username"/>
            <TextInput source="phone" label="Phone"/>
            <ArrayInput source="roles" label="Roles">
                <SimpleFormIterator>
                    <TextInput />
                </SimpleFormIterator>
            </ArrayInput>
        </SimpleForm>
    </Create>
);

import React from 'react';
import { Create, SimpleForm, TextInput, email, required, ArrayInput, SimpleFormIterator } from 'react-admin';
import { getResourceField } from '@api-platform/admin/lib/docsUtils';

export const UserCreate = props => {
    const {options: {inputFactory, resource}} = props;

    return (
        <Create {...props}>
            <SimpleForm>
                <div className="custom-grid">
                    <div className="column">
                        {inputFactory(getResourceField(resource, 'fullname'))}
                    </div>
                    <div className="column">
                        {inputFactory(getResourceField(resource, 'username'))}
                    </div>
                    <div className="column">
                        {inputFactory(getResourceField(resource, 'email'))}
                    </div>
                    <div className="column">
                        {inputFactory(getResourceField(resource, 'plainPassword'))}
                    </div>
                    <div className="column">
                        {inputFactory(getResourceField(resource, 'isActive'))}
                    </div>

                    <div className="column">
                        <ArrayInput source="roles" label="Roles">
                            <SimpleFormIterator>
                                <TextInput />
                            </SimpleFormIterator>
                        </ArrayInput>
                    </div>
                </div>
            </SimpleForm>
        </Create>
    );
};
