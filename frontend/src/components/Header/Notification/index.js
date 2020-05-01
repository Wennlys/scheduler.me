import React from "react";

import { Notification, NotificationList } from "./styles";

const Notifications = () => {
    return (
      <NotificationList>
          <Notification unread>
              <p>Você tem um novo agendamento para amanhã</p>
              <time>há 2 dias</time>
              <button type="button">Marcar como lida</button>
          </Notification>
          <Notification unread>
              <p>Você tem um novo agendamento para amanhã</p>
              <time>há 2 dias</time>
              <button type="button">Marcar como lida</button>
          </Notification>
          <Notification>
              <p>Você tem um novo agendamento para amanhã</p>
              <time>há 2 dias</time>
              <button type="button">Marcar como lida</button>
          </Notification>
      </NotificationList>
    );
};

export default Notifications;
