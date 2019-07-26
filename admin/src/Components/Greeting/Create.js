import React from 'react';
import { Create, SimpleForm } from 'react-admin';
import { getResourceField } from '@api-platform/admin/lib/docsUtils';

export const GreetingCreate = props => {
    const {options: {inputFactory, resource}} = props;

    return (
        <Create {...props}>
            <SimpleForm>
                <div className="custom-grid">
                    <div className="column">
                        {inputFactory(getResourceField(resource, 'name'))}
                    </div>
                    {/*<div className="column">*/}
                    {/*    {inputFactory(getResourceField(resource, 'description'))}*/}
                    {/*</div>*/}
                </div>
            </SimpleForm>
        </Create>
    );
};
