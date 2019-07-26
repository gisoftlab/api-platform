import React from 'react';
import { Edit, SimpleForm } from 'react-admin';
import { getResourceField } from '@api-platform/admin/lib/docsUtils';

export const GreetingEdit = props => {
    const {options: {inputFactory, resource}} = props;

    return (
        <Edit {...props}>
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
        </Edit>
    );
};
