import React from 'react';
import { Route, Redirect } from 'react-router-dom';

import Layout from '~/pages/_layouts/default';

import { store } from '~/store';

export default function RouteWrapper ({ component: Component }) {

  const { provider, signed } = store.getState().auth;

  if (!signed) {
    return <Redirect to='/' />;
  }

  return (
    <Route
      render={() => (
        <Layout>
          {provider ?  <Component.provider /> : <Component.client /> }
        </Layout>
      )}
    />
  )
}
