import React from 'react'
import { Switch } from 'react-router-dom'

import Route from './Route'

import Home from '~/pages/Home'
import ProviderDashboard from '~/pages/ProviderDashboard'
import Dashboard from '~/pages/ClientDashboard'

import Profile from '~/pages/Profile'

const provider = false

export default function Routes () {
  return (
    <Switch>
      <Route path='/' exact component={Home} />
      <Route
        path='/dashboard'
        component={provider ? ProviderDashboard : Dashboard}
        isPrivate
      />
      <Route path='/profile' component={Profile} isPrivate />
      <Route path='/' component={() => <h1>404</h1>} />
    </Switch>
  )
}
