// import React from 'react';
// import { HydraAdmin } from '@api-platform/admin';
//
// export default () => <HydraAdmin entrypoint={process.env.REACT_APP_API_ENTRYPOINT}/>;

// import React, { Component } from 'react';
// import { HydraAdmin } from '@api-platform/admin';
// import { createMuiTheme } from '@material-ui/core/styles';
//
// import { Layout } from './layout';
//
// const theme = createMuiTheme({
//     palette: {
//         primary: {
//             main: '#38a9b4',
//             contrastText: '#fff',
//         },
//         secondary: {
//             main: '#903a4b',
//         },
//     },
// });
//
//
// class App extends Component {
//     render() {
//         return <HydraAdmin appLayout={Layout} theme={theme} entrypoint={process.env.REACT_APP_API_ENTRYPOINT}/>;
//     }
// }
//
// export default App;


// import React, { Component } from 'react';
// import { HydraAdmin } from '@api-platform/admin';
//
// class App extends Component {
//     render() {
//         return <HydraAdmin entrypoint={process.env.REACT_APP_API_ENTRYPOINT}/>;
//     }
// }
//
// export default App;

//
import React, { Component } from 'react';
import { Admin, Resource } from 'react-admin';
import parseHydraDocumentation from '@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation';
import { HydraAdmin, hydraClient, fetchHydra as baseFetchHydra  } from '@api-platform/admin';
//import authProvider from './authProvider';
import { Redirect } from 'react-router-dom';
import { createMuiTheme } from '@material-ui/core/styles';
//import Layout from './Component/Layout';
import { Layout } from './layout';
import { UserShow } from './Components/User/Show';
import { UserEdit } from './Components/User/Edit';
import { UserCreate } from './Components/User/Create';
import { UserList } from './Components/User/List';
import { AccountShow } from './Components/Account/Show';
import { AccountEdit } from './Components/Account/Edit';
import { AccountCreate } from './Components/Account/Create';
import { AccountList } from './Components/Account/List';
import { ProductShow } from './Components/Product/Show';
import { ProductEdit } from './Components/Product/Edit';
import { ProductCreate } from './Components/Product/Create';
import { ProductList } from './Components/Product/List';
const theme = createMuiTheme({
    palette: {
        type: 'light'
    },
});

const entrypoint = process.env.REACT_APP_API_ENTRYPOINT;
const fetchHeaders = {'Authorization': `Bearer ${window.localStorage.getItem('token')}`};
const fetchHydra = (url, options = {}) => baseFetchHydra(url, {
    ...options,
    headers: new Headers(fetchHeaders),
});
const dataProvider = api => hydraClient(api, fetchHydra);
const apiDocumentationParser = entrypoint => parseHydraDocumentation(entrypoint, { headers: new Headers(fetchHeaders) })
    .then(
        ({ api }) => ({api}),
        (result) => {
            switch (result.status) {
                case 401:
                    return Promise.resolve({
                        api: result.api,
                        customRoutes: [{
                            props: {
                                path: '/',
                                render: () => <Redirect to={`/login`}/>,
                            },
                        }],
                    });

                default:
                    return Promise.reject(result);
            }
        },
    );

export default class extends Component {
    state = { api: null };

    componentDidMount() {
        apiDocumentationParser(entrypoint).then(({ api }) => {
            this.setState({ api });
        }).catch((e) => {
            console.log(e);
        });
    }

    render() {
        if (null === this.state.api) return <div>Loading...</div>;
        return (
            <Admin api={ this.state.api }
                   apiDocumentationParser={ apiDocumentationParser }
                   dataProvider= { dataProvider(this.state.api) }
                   theme={ theme }
                   appLayout={ Layout }
                  // authProvider={ authProvider }
            >
                {/*<Resource name="users" list={ UserList } create={ UserCreate } show={ UserShow } edit={ UserEdit } title="Users"/>*/}
                <Resource name="users" list={ UserList } reate={ UserCreate } show={ UserShow } edit={ UserEdit } />
                <Resource name="accounts" list={ AccountList } reate={ AccountCreate } show={ AccountShow } edit={ AccountEdit } />
                <Resource name="products" list={ ProductList } reate={ ProductCreate } show={ ProductShow } edit={ ProductEdit } />
            </Admin>

            //<HydraAdmin entrypoint={process.env.REACT_APP_API_ENTRYPOINT}/>
        )
    }
}
