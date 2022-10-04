import parse from 'html-react-parser';

import twigTemplate from './page-intro.twig';
import data from './page-intro.yml';
import extendedData from './page-intro--extended.yml';
import simpleData from './page-intro--simple.yml';

const settings = {
  title: 'Components/Page Intro'
};

const PageIntro = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
PageIntro.args = { ...data };

const PageIntroExtended = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
PageIntroExtended.args = { ...extendedData };

const PageIntroSimple = args =>
  parse(
    twigTemplate({
      ...args,
    })
  );
PageIntroSimple.args = { ...simpleData };

export default settings;
export { PageIntro, PageIntroExtended, PageIntroSimple };
