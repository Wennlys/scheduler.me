import React from 'react'
import { Switch } from 'react-router-dom'

import DefaultRoute from './Route'
import DashboardRoute from './DashboardRoute';
import ScheduleRoute from './ScheduleRoute';

import Home from '~/pages/Home'
import Profile from '~/pages/Profile'
import ClientDashboard from '~/pages/ClientDashboard';
import ProviderDashboard from '~/pages/ProviderDashboard';
import SelectDateTime from "~/pages/Schedule/SelectDateTime";
import SelectProvider from "~/pages/Schedule/SelectProvider";
import Confirm from "~/pages/Schedule/Confirm";

export default function Routes () {

  return (
    <Switch>
      <DefaultRoute path='/' exact component={ Home }/>
      <DashboardRoute path='/dashboard' component={{ client: ClientDashboard, provider: ProviderDashboard}}/>/>
      <DefaultRoute path='/profile' component={ Profile } isPrivate/>
      <ScheduleRoute path='/schedule' component={{ dateTime: SelectDateTime, provider: SelectProvider, confirm: Confirm}} />
    </Switch>
  );
}
