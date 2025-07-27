import Layout from '../components/Layout';
import { useTranslation } from 'react-i18next';

export default function About() {
  const { t } = useTranslation();

  return (
    <Layout>
      <div className="max-w-2xl mx-auto mt-20 text-center">
        <h1 className="text-4xl font-semibold text-gray-800 mb-4">{t('about.title')}</h1>
        <p className="text-gray-600 mb-6">{t('about.description1')}</p>
        <p className="text-gray-600">{t('about.description2')}</p>
      </div>
    </Layout>
  );
}
