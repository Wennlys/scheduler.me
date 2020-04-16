import React from "react";
import { Link } from "react-router-dom";

import logo from "~/assets/calendar.svg";
import profile from "~/assets/calendar.png";

import { Container, Content, Profile } from "./styles";

const Header = () => {
    return (
        <Container>
            <Content>
                <nav>
                    <img src={logo} alt="Scheduler" />
                    <Link to="/dashboard">DASHBOARD</Link>
                </nav>

                <aside>
                    <Profile>
                        <div>
                            <strong>Wennlys Oliveira</strong>
                            <Link to="/profile">Meu perfil</Link>
                        </div>
                        <img src={profile} alt="Wennlys Oliveira" />
                    </Profile>
                </aside>
            </Content>
        </Container>
    );
};

export default Header;
