import React from 'react';
import { Route } from 'react-router-dom';
import Configuration from './Components/Configuration/Configuration';
import Profile from './Components/Profile/Profile';
import CustomRouteNoLayout from "./customRouteNoLayout";
//import Segments from './segments/Segments';

export default [
    <Route
        exact
        path="/custom"
        component={CustomRouteNoLayout}
        noLayout
    />,
    <Route exact path="/configuration" component={Configuration} />,
    <Route exact path="/profile" component={Profile} />,
    //<Route exact path="/segments" component={Segments} />,
];
