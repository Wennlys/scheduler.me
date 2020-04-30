import React from 'react'
import PropTypes from 'prop-types'
import { Route, Redirect } from 'react-router-dom'

import Layout from '~/pages/_layouts/default'
import Home from '~/pages/Home'

import { store } from '~/store';

export default function RouteWrapper ({ component: Component, isPrivate, ...rest }) {
  const { signed } = store.getState().auth;

  if (!signed && isPrivate) {
    return <Redirect to='/' />
  }

  if (signed && !isPrivate) {
    return <Redirect to='/dashboard' />
  }

  const LayoutComponent = signed ? Layout : Home

  return (
    <Route
      {...rest}
      render={props => (
        <LayoutComponent>
          <Component {...props} />
        </LayoutComponent>
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
