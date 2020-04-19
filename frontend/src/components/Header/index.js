import React from "react";

import logo from "~/assets/calendar.svg";
import profile from "~/assets/profile.png";
import burger from "~/assets/burger.svg";

import { Container, Content, Profile } from "./styles";

const Header = () => {
    return (
        <Container>
            <Content>
                <aside>
                    <Profile>
                        <img src={profile} alt="Wennlys Oliveira" />
                        <hr/>
                        <div className="title">Wennlys Oliveira</div>
                    </Profile>
                </aside>
                    <img src={logo} alt="logo" />
                    <div><img src={burger} alt="menu" /></div>
            </Content>
        </Container>
    );
};

export default Header;
