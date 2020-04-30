import React from 'react'
import { Switch } from 'react-router-dom'

import Route from './Route'
import DashboardRoute from './DashboardRoute';

import Home from '~/pages/Home'
import Profile from '~/pages/Profile'

export default function Routes () {

  return (
    <Switch>
      <Route path='/' exact component={ Home } />
      <DashboardRoute path='/dashboard' exact/>
      <Route path='/profile' component={ Profile } isPrivate />
      <Route path='/' component={ () => <h1>404</h1> } />
    </Switch>
  )
}
