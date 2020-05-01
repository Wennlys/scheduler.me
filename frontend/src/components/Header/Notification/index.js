import React, { useState, useEffect, useMemo } from "react";
import { formatDistance } from 'date-fns';
import pt from 'date-fns/locale/pt';

import { Notification, NotificationList, Scroll } from "./styles";

import api from '~/services/api';

const Notifications = props => {
  const [notifications, setNotifications] = useState([]);

  useMemo(
    () => props.isRead(!!notifications.find(notification => notification.read === false))
  , [notifications]
  );

  useEffect(() => {
    async function loadNotifications() {
      const response = await api.get('/notifications');

      const data = response.data.map(notification => ({
        ...notification,
        timeDistance: formatDistance(
          new Date(notification.created_at.replace(/-/g, "/")),
          new Date(),
          { addSuffix: true, locale: pt})
      }));
      setNotifications(data);
    }

    loadNotifications();
  }, [])

  async function handleMarkAsRead(id) {
    await api.put(`notifications/${ id }`);

    setNotifications(
      notifications.map(notification => notification._id.$oid === id ? {
        ...notification,
        read: true
      } : notification)
    );
  }

  return (
    <NotificationList>
      <Scroll>
        { notifications.map(notification => (
          <Notification key={ notification._id.$oid } unread={ !notification.read }>
            <p>{ notification.content }</p>
            <time>{ notification.timeDistance }</time>
            { !notification.read &&
              <button type="button" onClick={ () => handleMarkAsRead(notification._id.$oid) }>
                Marcar como lida
              </button>
            }
          </Notification>
        )) }
      </Scroll>
    </NotificationList>
  );
};

export default Notifications;
