import React, { useState } from 'react';
import { Route, Redirect } from 'react-router-dom';

import Layout from '~/pages/_layouts/default';

import { store } from '~/store';

export default function ScheduleRoute ({ component: Component}) {
  const [page, setPage] = useState({ number: 0, state: {} });
  const { provider, signed } = store.getState().auth;

  if (!signed || provider) {
    return <Redirect to='/' />;
  }

  function renderRoute () {
    switch (page.number) {
      case 0: return <Component.provider setPage={ setPage }/>;
      case 1 : return <Component.dateTime page={ page } setPage={ setPage }/>;
      case 2: return <Component.confirm page={ page } setPage={ setPage }/>;
      default:
    }
  }

  return <Route
    render={ () => (
      <Layout>
        {renderRoute()}
      </Layout>
    )}
  />;
}
