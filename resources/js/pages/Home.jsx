import React from "react";
import Layout from "../components/Layout";
import { useTranslation } from "react-i18next";

export default function Home() {
    const { t } = useTranslation();

    return (
        <Layout>
            <h1 className="text-4xl font-bold text-blue-600 mb-4 text-center">
                {t("home.welcome")}
            </h1>
            <p className="text-gray-700 text-lg text-center max-w-xl mx-auto">
                {t("home.description")}
            </p>
        </Layout>
    );
}
