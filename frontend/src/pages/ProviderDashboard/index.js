import React from "react";
import { MdChevronLeft, MdChevronRight } from "react-icons/all";

import { Container, Time } from "~/pages/ProviderDashboard/styles";

const Dashboard = () => {
    return (
        <Container>
            <header>
                <button type="button">
                    <MdChevronLeft size={36} color="#ffffff" />
                </button>
                <strong>15 de março</strong>
                <button type="button">
                    <MdChevronRight size={36} color="#ffffff" />
                </button>
            </header>

            <ul>
                <Time past>
                    <strong>8:00</strong>
                    <span>Wennlys Oliveira</span>
                </Time>
                <Time available>
                    <strong>8:00</strong>
                    <span>Wennlys Oliveira</span>
                </Time>
                <Time>
                    <strong>8:00</strong>
                    <span>Wennlys Oliveira</span>
                </Time>
                <Time>
                    <strong>8:00</strong>
                    <span>Wennlys Oliveira</span>
                </Time>
                <Time>
                    <strong>8:00</strong>
                    <span>Wennlys Oliveira</span>
                </Time>
            </ul>
        </Container>
    );
};

export default Dashboard;
