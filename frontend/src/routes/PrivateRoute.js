import React from 'react';
import PropTypes from 'prop-types';
import { Route, Redirect } from 'react-router-dom';

import Layout from '~/pages/_layouts/default';
import ProviderDashboard from '~/pages/ProviderDashboard';
import ClientDashboard from '~/pages/ClientDashboard';

import store from '~/store';

export default function RouteWrapper ({ ...rest }) {
  const { provider, signed } = store.getState().auth;
  console.table(provider, signed);

  if (!signed) {
    return <Redirect to='/' />;
  }

  /* eslint react/jsx-props-no-spreading:0 */
  return (
    <Route
      {...rest}
      render={props => (
        <Layout>
          {provider ?  <ProviderDashboard {...props} /> : <ClientDashboard {...props} />}
        </Layout>
      )}
    />
  )
}

RouteWrapper.propTypes = {
  isPrivate: PropTypes.bool,
  component: PropTypes.oneOfType([PropTypes.element, PropTypes.func]).isRequired
}

RouteWrapper.defaultProps = {
  isPrivate: false
}
