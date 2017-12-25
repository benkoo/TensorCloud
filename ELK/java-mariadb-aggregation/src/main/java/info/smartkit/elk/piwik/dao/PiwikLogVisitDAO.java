package info.smartkit.elk.piwik.dao;

import info.smartkit.elk.piwik.domain.PiwikLogVisit;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PiwikLogVisitDAO extends CrudRepository<PiwikLogVisit,Long> {
}
