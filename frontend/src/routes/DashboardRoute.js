import React from 'react';
import { Route, Redirect } from 'react-router-dom';

import Layout from '~/pages/_layouts/default';
import ProviderDashboard from '~/pages/ProviderDashboard';
import ClientDashboard from '~/pages/ClientDashboard';

import { store } from '~/store';

export default function RouteWrapper () {
  const { provider, signed } = store.getState().auth;

  if (!signed) {
    return <Redirect to='/' />;
  }

  return (
    <Route
      render={() => (
        <Layout>
          {provider ?  <ProviderDashboard /> : <ClientDashboard />}
        </Layout>
      )}
    />
  )
}
