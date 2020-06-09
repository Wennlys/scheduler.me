import React, { useEffect, useState } from 'react'
import { formatRelative } from "date-fns";
import pt from "date-fns/locale/pt";

import api from '~/services/api';

import { Container, Appointment } from './styles'

import remove from '~/assets/delete.svg';
import { Link } from "react-router-dom";

const ClientDashboard = () => {
  const [trigger, setTrigger] = useState(false);
  const [appointments, setAppointments] = useState([]);

  useEffect(() => {
    async function loadAppointments () {
      const response = await api.get('appointments', {
        params: { page: 1 }
      });

      setTrigger(false);

      response.data = response.data ? response.data.map(appointment => ({
        ...appointment,
        parsedDate: formatRelative(
           new Date(appointment.date.replace(/-/g, "/")),
           new Date(),
            { addSuffix: true, locale: pt })
      })) : null;

      setAppointments(response.data);
    }
    loadAppointments();
  }, [trigger]);

  async function handleDelete(id) {
    await api.delete(`appointments/${id}`);
    setTrigger(true)
  }

  return (
    <Container>
      <ul>
        { appointments ? appointments.map(appointment => (
          <Appointment key={ appointment.id } past={ appointment.past }>
            <span>
              <img src={ appointment.provider.avatar.url } alt='profile'/>
              <span>
                <strong>{ appointment.provider.name }</strong>
                <p>{ appointment.parsedDate }</p>
              </span>
                <img src={ remove } alt='delete' onClick={ () => handleDelete(appointment.id) }/>
            </span>
          </Appointment>
        )) : (<>
          <Appointment>Não há agendamentos, faça o seu primeiro!</Appointment>
          <Appointment>
            <Link to='/schedule'>
              <button>
                Clique aqui para fazer seu primeiro agendamento.
              </button>
            </Link>
          </Appointment></>) }
      </ul>
    </Container>
  );
}

export default ClientDashboard
